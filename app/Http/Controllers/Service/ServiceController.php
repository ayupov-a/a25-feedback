<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index(): string
    {
        return Service::all()->toJson(JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
