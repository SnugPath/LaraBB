<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class DashboardController extends AdminController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @throws Exception
     */
    public function admin(): View
    {
        return view('admin.index');
    }

}
