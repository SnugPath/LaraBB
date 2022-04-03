<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private User $user;
    public function __construct(int $id)
    {
        $this->user = User::where('id', $id)
            ->get();

    }

    public static function getUser(int $id): UserService {
        return new UserService($id);
    }

    public static function getCurrentUser(): UserService {
        $id = Auth::id();
        return new UserService($id);
    }

//    public function is(string $type): bool {
//        $number = $this->user->
//    }
}
