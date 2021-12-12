<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use \Illuminate\Contracts\Foundation\Application;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function admin(): Factory|View|Application
    {
        global $sidebar;
        $sidebar->add_section('Dashboard');
        $sidebar->add_menu('Home', 'Dashboard', '/');
        return view('admin.index');
    }

}
