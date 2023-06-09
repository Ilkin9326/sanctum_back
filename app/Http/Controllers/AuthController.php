<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Cookie;

class AuthController extends Controller
{
    use HttpResponses;

    public function getUsers(): JsonResponse
    {
        $strSql = 'select u.id, u.name, u.email from users u ';
        $data = DB::select($strSql);

        return $this->success($data);
    }

    public function login(Request $request)
    {
        /*$fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);*/

        // Check email
        $user = User::where('email', $request->input('email'))->first();

        // Check Password
        if (! $user || ! Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return $this->error(null, 'Invalid credentials', 401);
        }

        // Delete old tokens
        /*$user->tokens()->delete();*/

        // Create new tokens
        /*$token = $user->createAuthToken('api')->plainTextToken;
        $refresh = $user->createRefreshToken('api')->plainTextToken;
        $accessToken = $user->createToken('access_token', ['server:update'])->plainTextToken;*/

        //$cookie = cookie('angular', $accessToken, 15); // 1 week 60 * 24 * 7
        //$request->session()->regenerate();

        // Return user, token and set refresh cookie
        return $this->success('success');
    }

    public function ilkin(): JsonResponse
    {
        $user = User::all();
        ds($user);
        return response()->json('salam qaqas', 201);
    }

    public function saveUserInfo(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        $pasword = Hash::make($request->input('password'));

        $userStoreInfo = DB::insert('insert into users(name, email, password) values(?,?,?)',
            [$request->input('name'), $request->input('email'), $pasword]);

        return $this->success($userStoreInfo, 'Ugurlar qeyd olundu', 200);
    }

    public function logOut(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        $request->session()->flush();

        return $this->success('Log out edildi');
    }

    public function checkLogin()
    {
        return $this->success('true');
    }
}
