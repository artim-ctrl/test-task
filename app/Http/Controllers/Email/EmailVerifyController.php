<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;

class EmailVerifyController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        $request->fulfill();

        return response()->json(['ok']);
    }
}
