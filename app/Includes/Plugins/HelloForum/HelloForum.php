<?php

namespace App\Includes\Plugins\HelloForum;

use App\Helpers\Classes\AdminMessage;
use App\Helpers\Classes\Plugin;

class HelloForum extends Plugin
{

    private readonly AdminMessage $adminMessage;

    public function __construct(AdminMessage $adminMessage)
    {
        $this->adminMessage = $adminMessage;
    }

    public function onLoad(): void
    {
        $this->adminMessage->add(
            "Hi! Thanks for activate this plugin. Remember, this plugin is a base for every developer to create their own plugins."
        );
    }

    public function onUpdate(): void
    {
        // TODO: Implement onUpdate() method.
    }

    public function onActivate(): void
    {
        $this->adminMessage->add(
            "Hi! Thanks for activate this plugin. Remember, this plugin is a base for every developer to create their own plugins."
        );
    }

    public function onDeactivate(): void
    {
        // TODO: Implement onDeactivate() method.
    }
}
