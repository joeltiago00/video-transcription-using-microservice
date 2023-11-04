<?php

namespace Tests\Feature\FileUpload;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\FeatureTest;
use Tests\Providers\FileUpload\FileUploadProvider as Provider;
use Upload\Messaging\Messaging;

class FileUploadTest extends FeatureTest
{
    private const ROUTE = 'file-upload';

    /**
     * @group l
     */
    public function testSuccessWithoutExistingFileAndCreatingUser()
    {
//        Messaging::fake();
        Storage::fake('s3');
        $payloadSuccess = Provider::payloadSuccess();

        $response = $this->postJson(route(self::ROUTE), $payloadSuccess);

        $user = User::query()->latest('created_at')->first();

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        Storage::disk('s3')->assertExists(sprintf('users/%s/video/mp4/video.mp4', $user->getKey()));
        $this->assertDatabaseHas('users', ['email' => $payloadSuccess['email']]);
    }

    public function testSuccessExistingFile()
    {
        Messaging::fake();
        Storage::fake('s3');

        $user = User::factory()->create(['email_verified_at' => now()]);
        $userId = $user->getKey();

        Storage::disk('s3')->put(sprintf('users/%s/video/mp4/video.mp4', $userId), 'fake');

        $response = $this->postJson(route(self::ROUTE), Provider::payloadSuccess($user->email));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        Storage::disk('s3')->assertExists(sprintf('users/%s/video/mp4/(1)video.mp4', $userId));
    }

    public function testFailInvalidEmail()
    {
        $response = $this->postJson(route(self::ROUTE), Provider::payloadInvalidEmail());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(Provider::errorInvalidEmail());
    }

    public function testFailInvalidFile()
    {
        $response = $this->postJson(route(self::ROUTE), Provider::payloadInvalidFile());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(Provider::errorInvalidFile());
    }

    public function testFailInvalidParameters()
    {
        $response = $this->postJson(route(self::ROUTE), Provider::payloadInvalidParameters());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(Provider::errorInvalidParameters());
    }
}
