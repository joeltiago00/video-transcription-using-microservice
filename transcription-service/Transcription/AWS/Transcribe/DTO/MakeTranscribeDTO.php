<?php

namespace Transcription\AWS\Transcribe\DTO;

class MakeTranscribeDTO
{
    private string $languageCode;

    private string $fileUrl;

    private string $transcriptionKey;

    private array $payload = [];

    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    public function setLanguageCode(string $languageCode): self
    {
        $this->languageCode = $languageCode;

        return $this;
    }

    public function getFileUrl(): string
    {
        return $this->fileUrl;
    }

    public function setFileUrl(string $fileUrl): self
    {
        $this->fileUrl = $fileUrl;

        return $this;
    }

    public function setTranscriptionKey(string $transcriptionKey): self
    {
        $this->transcriptionKey = $transcriptionKey;

        return $this;
    }

    public function getTranscriptionKey(): string
    {
        return $this->transcriptionKey;
    }


}
