<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Helpers\ResponseFormatterController;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|email:dns|max:255|unique:users',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.string' => 'Email harus berupa string',
            'email.email' => 'Email tidak valid',
            'email.dns' => 'Email tidak valid',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa string',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        if ($data->fails()) {
            return ResponseFormatterController::error($data->errors(), 422);
        }

        $user = Http::user()->post('auth/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if($user->failed())
        {
            return ResponseFormatterController::error($user->json()['message'], $user->status());
        }

        return ResponseFormatterController::success($user->json()['data'], 'Berhasil Daftar');
    }

    public function login(Request $request)
    {
        $data = Validator::make($request->all(), [
            'email' => 'required|string|email|email:dns|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($data->fails()) {
            return ResponseFormatterController::error($data->errors(), 422);
        }

        $user = Http::user()->post('auth/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if($user->failed())
        {
            return ResponseFormatterController::error($user->json()['message'], $user->status());
        }

        return ResponseFormatterController::success($user->json()['data'], 'Berhasil Login');
    }
}
