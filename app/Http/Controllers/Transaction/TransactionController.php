<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Helpers\ResponseFormatterController;

class TransactionController extends Controller
{
    public function index()
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
