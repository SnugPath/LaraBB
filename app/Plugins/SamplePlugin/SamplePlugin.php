<?php

namespace App\Plugins\SamplePlugin;

use App\Helpers\Classes\Plugin;
use Illuminate\Support\Facades\Log;

class SamplePlugin extends Plugin
{
    public function onInstall(): void
    {
        // TODO: Implement onInstall() method.
    }

    public function onLoad(): void
    {
        Log::info("Loaded plugin");
    }

    public function onUpdate(): void
    {
        // TODO: Implement onUpdate() method.
    }

    public function onActivate(): void
    {
        // TODO: Implement onActivate() method.
    }

    public function onDeactivate(): void
    {
        // TODO: Implement onDeactivate() method.
    }
}
