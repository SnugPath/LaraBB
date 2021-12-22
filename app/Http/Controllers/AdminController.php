<?php

namespace App\Http\Controllers;

use App\Helpers\Sidebar;
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

    /**
     * @throws \Exception
     */
    public function admin(): Factory|View|Application
    {
        Sidebar::addSection('Dashboard', 0)
            ->addMenu('Home', 0, '/', false)
            ->addMenu('About', 1, '/')
            ->addSubmenu('Contact', 0, '/');

        return view('admin.index');
    }

}
