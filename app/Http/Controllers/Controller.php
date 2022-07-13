<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function return_json_response(int $code, array $data)
    {
        return response()
            ->json(
                [
                    "code" => $code,
                    ...$data
                ],
                $code,
                [JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT]
            );
    }
}
