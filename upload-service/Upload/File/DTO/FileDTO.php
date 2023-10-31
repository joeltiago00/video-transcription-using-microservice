<?php

namespace Upload\File\DTO;

class FileDTO
{
    public function __construct(
        public readonly string $path,
        public readonly string $mimetype,
        public readonly float  $size
    )
    {
    }

    public function toArray(): array
    {
        return [
            'path' => $this->path,
            'mimetype' => $this->mimetype,
            'size' => $this->size
        ];
    }
}
