<?php

namespace Repositories\File;

use App\Models\File;
use Upload\File\DTO\FileDTO;

class FileEloquentRepository implements FileRepository
{
    public function __construct(private readonly File $model)
    {
    }


    public function store(FileDTO $dto): File
    {
        /** @var File */
        return $this->model
            ->newQuery()
            ->create($dto->toArray());
    }
}
