<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ForumRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ForumController extends Controller
{
    private ForumRepositoryInterface $forum_repository;

    public function __construct(ForumRepositoryInterface $repository)
    {
        $this->forum_repository = $repository;
    }

    public function get_all()
    {
        return $this->forum_repository->all();
    }

    public function file_url(Request $request)
    {
        $file_name = $request->query('filename');
        return response()->json(["exists" => Storage::disk('s3')->exists($file_name)], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
