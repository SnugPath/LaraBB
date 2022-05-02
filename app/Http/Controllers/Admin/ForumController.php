<?php

namespace App\Http\Controllers\Admin;

use App\Models\Forum;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ForumController extends AdminController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private Forum $forum;

    public function __construct(Forum $forum)
    {
        parent::__construct();
        $this->forum = $forum;
    }

    /**
     * @throws Exception
     */
    public function categories(): View
    {
        return view('admin.categories', ['categories' => $this->forum->get_categories()]);
    }
}
