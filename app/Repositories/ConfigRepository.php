<?php

namespace App\Repositories;

use App\Models\Config;
use App\Repositories\Interfaces\ConfigRepositoryInterface;

class ConfigRepository implements ConfigRepositoryInterface
{
    private Config $config_model;

    public function __construct(Config $config_model)
    {
        $this->config_model = $config_model;
    }

    public function getConfigOption(string $key): ?string
    {
        $config_details = $this->config_model->where('name', '=', $key)->first();

        return $config_details->value ?? null;
    }

    public function setConfigOption(string $key, string $value): void
    {
        $config_details = $this->getConfigOption($key);
        if($config_details == null)
        {
            $config_details = new $this->config_model();
            $config_details->name = $key;
        }

        $config_details->value = $value;

        $config_details->save();
    }
}
