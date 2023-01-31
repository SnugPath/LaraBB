<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Classes\AdminMenu\Sidebar;
use App\Helpers\Classes\Hook;
use Illuminate\Support\Facades\View;

class AdminController
{

    public function __construct(Sidebar $sidebar, Hook $hook)
    {
        $this->share(
            array(
                'sidebar' => $sidebar,
                'hook' => $hook,
                'user' => auth()->user()
            )
        );
    }

    private function share(array $variables): void {
        foreach ($variables as $name => $var) {
            View::share($name, $var);
        }
    }

}
