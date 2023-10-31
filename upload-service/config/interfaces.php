<?php

return [
    \Repositories\User\UserRepository::class => \Repositories\User\UserEloquentRepository::class,
    \Repositories\File\FileRepository::class => \Repositories\File\FileEloquentRepository::class,
    \Repositories\Transcription\TranscriptionRepository::class => \Repositories\Transcription\TranscriptionEloquentRepository::class,
    \Repositories\UserEmailConfirmationToken\UserEmailConfirmationTokenRepository::class => \Repositories\UserEmailConfirmationToken\UserEmailConfirmationTokenEloquentRepository::class,
    \Repositories\UserFileTranscription\UserFileTranscriptionRepository::class => \Repositories\UserFileTranscription\UserFileTranscriptionEloquentRepository::class
];
