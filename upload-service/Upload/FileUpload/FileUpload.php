<?php

namespace Upload\FileUpload;

use App\Enums\CacheEnum;
use App\Enums\MessageEnum;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Repositories\User\UserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Upload\Cache\AppendCache;
use Upload\File\SaveFile;
use Upload\Messaging\MessagePublishEmailHandler;
use Upload\Transcription\StoreTranscription;
use Upload\User\GetUser;
use Upload\UserFileTranscription\StoreUserFileTranscription;

class FileUpload
{

    public function __construct(
        private readonly GetUser                    $getUser,
        private readonly SaveFile                   $saveFile,
        private readonly StoreTranscription         $storeTranscription,
        private readonly StoreUserFileTranscription $storeUserFileTranscription,
        private readonly AppendCache                $appendCache
    )
    {
    }

    public function handle(array $data): void
    {
        DB::transaction(function () use ($data) {
            $user = $this->getUser->handle($data['email']);
            $userId = $user->getKey();

            $file = $this->saveFile->handle($data['file'], $userId);

            $transcription = $this->storeTranscription->handle();

            $this->storeUserFileTranscription->handle($userId, $file->getKey(), $transcription->getKey());

            $this->addDataToTranscriptionInfoEmailInCache($user, $file);
            $this->addDataToGenerateTranscriptionInCache($user, $file);

            MessagePublishEmailHandler::handle();
        });
    }

    private function addDataToTranscriptionInfoEmailInCache(User $user, File $file): void
    {
        $this->appendCache->handle(CacheEnum::EMAIL->key(), [
            'channel' => 'email',
            'type' => MessageEnum::TRANSCRIPTION_INFO->type(),
            'user_id' => $user->getKey(),
            'to' => $user->email,
            'routing_key' => MessageEnum::TRANSCRIPTION_INFO->routingKey(),
            'email_data' => [
                'file_name' => basename($file->path)
            ]
        ]);
    }

    private function addDataToGenerateTranscriptionInCache(User $user, File $file): void
    {
        $this->appendCache->handle(CacheEnum::EMAIL->key(), [
            'channel' => 'transcription',
            'type' => MessageEnum::TRANSCRIPTION_GENERATE->type(),
            'user_id' => $user->getKey(),
            'to' => $user->email,
            'routing_key' => MessageEnum::TRANSCRIPTION_GENERATE->routingKey(),
            'transcription_data' => [
                'file_path' => $file->path,
                //TODO:: implement language selector
            ]
        ]);
    }
}
