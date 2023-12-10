<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $user = User::create($request->validated());

        return new UserResource($user);
    }

    public function login(LoginUserRequest $request)
    {
        $cridentials = $request->getCridentials();

        $token = Auth::attempt($cridentials);

        if (!$token) {
            throw new HttpException(401, "username or password is wrong");
        }

        return new TokenResource($token);
    }

    public function current()
    {
        return new UserResource(Auth::user());
    }

    public function update(UpdateUserRequest $request)
    {
        $data = $request->validated();
        $user = User::find(Auth::user()->id);

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        if (isset($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return new UserResource($user);
    }
}
