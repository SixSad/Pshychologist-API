<?php

declare(strict_types=1);

namespace App\Console\Commands;

class DebugModelMakeCommand extends MakeCommand
{
    /**
     * @var string
     */
    protected $signature = 'egal:make:debugModel
                            {name     : Model name}
                           ';

    /**
     * @var string
     */
    protected $description = 'DebugModel class generating';

    protected string $stubFileBaseName = 'debug';

    private string $debugPrefix = "DebugModel";

    public function handle(): void
    {
        $fileBaseName = (string) $this->argument('name');

        $extends = str_ends_with($fileBaseName, $this->debugPrefix)
            ? ucfirst((str_replace($this->debugPrefix, "", $fileBaseName)))
            : ucfirst($fileBaseName);

        $use = "App\\Models\\" . $extends;

        $table = strtolower($extends) . "s";

        $prefix = $this->debugPrefix;

        $this->fileBaseName = str_ends_with($fileBaseName, $prefix)
            ? $fileBaseName
            : $fileBaseName . $prefix;
        $this->filePath = base_path('app/DebugModels') . '/' . $this->fileBaseName . '.php';
        $this->setFileContents('{{ class }}', $this->fileBaseName);
        $this->setFileContents('{{ extends }}', $extends);
        $this->setFileContents('{{ use }}', $use);
        $this->setFileContents('{{ table }}', $table);
        $this->writeFile();
    }
}
