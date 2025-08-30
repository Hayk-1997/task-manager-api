<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\User\ChangeUserAvailabilityRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(
            User::whereDoesntHave('roles', function ($query) {
                $query->where('name', RoleEnum::ADMIN->value);
            })->get(['id', 'name', 'email', 'is_available'])
        );
    }

    public function toggleAvailability(User $user, ChangeUserAvailabilityRequest $request)
    {
        $user->is_available = $request->is_available;
        $user->save();

        return response()->json('User availability updated successfully.');
    }
}
