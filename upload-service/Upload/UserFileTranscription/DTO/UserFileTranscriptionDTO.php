<?php

namespace Upload\UserFileTranscription\DTO;

class UserFileTranscriptionDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly int $fileId,
        public readonly int $transcriptionId
    )
    {
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'file_id' => $this->fileId,
            'transcription_id' => $this->transcriptionId
        ];
    }
}
