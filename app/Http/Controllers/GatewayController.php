<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Helpers\ResponseFormatterController;

class GatewayController extends Controller
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

    public function kelas()
    {
        $kursus = Http::kursus()->get('kelas');

        return ResponseFormatterController::success($kursus->json()['data'], 'Berhasil Mengambil Data Kelas');
    }

    public function orders()
    {
        $orders = Http::transaksi()->get('dashboard/orders');

        return ResponseFormatterController::success($orders->json()['data'], 'Berhasil Mengambil Data Order');
    }

    public function daftar($slug)
    {
        $daftar = Http::transaksi()->withToken(request()->bearerToken())->post("checkout/{$slug}/daftar");

        if($daftar->failed())
        {
            return ResponseFormatterController::error($daftar->json()['message'], $daftar->status());
        }

        return ResponseFormatterController::success($daftar->json()['data'], 'Berhasil Membuat Order');
    }
}
