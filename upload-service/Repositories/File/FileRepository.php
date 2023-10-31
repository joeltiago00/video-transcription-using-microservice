<?php

namespace Repositories\File;

use App\Models\File;
use Upload\File\DTO\FileDTO;

interface FileRepository
{
    public function store(FileDTO $dto): File;
}
