<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdminController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function __construct()
    {
        global $sidebar;
        \Illuminate\Support\Facades\View::share('sidebar', $sidebar);
    }

    /**
     * @throws \Exception
     */
    public function admin(): Factory|View|Application
    {
        return view('admin.index');
    }

}
