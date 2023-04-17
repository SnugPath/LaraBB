<?php

namespace App\Helpers\Managers;

use Illuminate\Container\Container;

class BaseManager
{
    protected Container $app_container;

    public function __construct(Container $container) {
        $this->app_container = $container;
    }

    protected function extractNamespace($file): string {
        $namespace = NULL;
        $handle = fopen($file, "r");
        if ($handle)
        {
            while (($line = fgets($handle)) !== false)
            {
                if (str_starts_with($line, 'namespace'))
                {
                    $parts = explode(' ', $line);
                    $namespace = rtrim(trim($parts[1]), ';');
                    break;
                }
            }
            fclose($handle);
        }
        return $namespace;
    }
}
