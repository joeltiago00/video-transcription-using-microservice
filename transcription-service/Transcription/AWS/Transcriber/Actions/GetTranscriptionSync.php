<?php

namespace Transcription\AWS\Transcriber\Actions;

class GetTranscriptionSync
{
    public function __construct(private readonly GetTranscription $getTranscription)
    {
    }

    public function handle(string $transcriptionKey): string
    {
        do {
            $response = $this->getTranscription->handle($transcriptionKey);
        } while ($response->get('TranscriptionJob')['TranscriptionJobStatus'] !== 'COMPLETED');

        $transcriptionFile = $response->get('TranscriptionJob')['Transcript']['TranscriptFileUri'];

        $transcriptionContent = json_decode(file_get_contents($transcriptionFile), true);

        return $transcriptionContent['results']['transcripts'][0]['transcript'] ?? '';
    }
}
