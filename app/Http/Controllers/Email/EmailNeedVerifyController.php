<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class EmailNeedVerifyController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['need verify email']);
    }
}
