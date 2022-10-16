<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Core;
use Illuminate\Support\Facades\View;

class AdminController
{

    public function __construct()
    {
        $hook = Core::$hook;
        $this->share(
            array(
                'sidebar' => Core::$sidebar,
                'hook' => $hook,
                'user' => auth()->user()
            )
        );
        $hook->trigger('admin_menu');
    }

    private function share($variables): void {
        foreach ($variables as $name => $var) {
            View::share($name, $var);
        }
    }

}
