<?php

namespace Upload\FileUpload;

class GenerateFilePath
{
    private int $index = 1;

    public function __construct(private readonly SearchFile $searchFile)
    {
    }

    public function handle(string $basePath, string $fileName): string
    {
        $path = $this->getPath($basePath, $fileName);

        if (!$this->searchFile->handle($path)) {
            return $path;
        }

        do {
            $path = sprintf('%s', $this->getPath($basePath, $this->addIndexInFileName($fileName)));

            $this->index++;
        } while ($this->searchFile->handle($path));

        return $path;
    }

    private function getPath(string $basePath, string $fileName): string
    {
        return sprintf('%s/%s', $basePath, $this->removeSpaces($fileName));
    }

    private function removeSpaces(string $string): string
    {
        return str_replace(' ', '_', $string);
    }

    private function addIndexInFileName(string $fileName): string
    {
        return sprintf('(%s)%s', $this->index, $fileName);
    }
}
