<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Helpers\ResponseFormatterController;

class KelasController extends Controller
{
    public function index()
    {
        $kursus = Http::kursus()->get('kelas');

        return ResponseFormatterController::success($kursus->json()['data'], 'Berhasil Mengambil Data Kelas');
    }
}
