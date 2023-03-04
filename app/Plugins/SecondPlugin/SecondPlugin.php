<?php

namespace App\Plugins\SecondPlugin;

use App\Helpers\Classes\AdminMenu\Sidebar;
use App\Helpers\Classes\Hook;
use App\Helpers\Classes\Plugin;
use App\Repositories\CustomFieldTypeRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class SecondPlugin extends Plugin
{
    private CustomFieldTypeRepository $custom_field_type_repository;

    public function __construct(Hook $hook, Sidebar $sidebar, CustomFieldTypeRepository $custom_field_type_repository)
    {
        parent::__construct($hook, $sidebar);
        $this->custom_field_type_repository = $custom_field_type_repository;
    }

    public function onInstall(): void
    {
        // TODO: Implement onInstall() method.
    }

    public function onLoad(): void
    {
        Log::info("Loaded second plugin");
        $custom_field_types = $this->custom_field_type_repository->getCustomFieldTypes();
        Log::info($custom_field_types);
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
