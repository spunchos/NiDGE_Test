<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function loginForm(): View
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $data = $request->validate([
            "email"    => ["required", "email", "string"],
            "password" => ["required"],
        ]);

        if (auth("web")->attempt($data)){
            return redirect(route("service.index"));
        }

        return redirect(route("login"))->withErrors(["email" => "User not found"]);
    }

    public function logout()
    {
        auth("web")->logout();

        return redirect(route("service.index"));
    }

    public function registerForm(): View
    {
        return view('auth.register');
    }

    public function registerProcess(Request $request)
    {
        $data = $request->validate([
            "name"     => ["required", "string"],
            "email"    => ["required", "email", "string", "unique:users,email"],
            "phone"    => ["required", "string"],
            "password" => ["required", "confirmed"],
        ]);

        $user = User::create([
            "name"     => $data["name"],
            "email"    => $data["email"],
            "phone"    => $data["phone"],
            "password" => bcrypt($data["password"]),
        ]);

        if ($user)
        {
            auth("web")->login($user);
        }

        return redirect(route("service.index"));
    }
}
