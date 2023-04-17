<?php

namespace App\Repositories\Interfaces;

interface ConfigRepositoryInterface
{
    public function getConfigOption(string $key): ?string;

    public function setConfigOption(string $key, string $value): void;
}
