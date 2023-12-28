<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as RulesPassword;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Notifications\ResetPasswordNotification;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request)
    {

        $input = $request->only('email');
        $user = User::where('email', $input['email'])->first();

        if (!$user) {
            // Email doesn't exist, return an error response
            $errorResponse = [
                'status' => 'failed',
                'message' => 'Email was not found in our records.',
            ];

            return response()->json($errorResponse, 404);
        }

        // If email exists, send the reset password notification
        $user->notify(new ResetPasswordNotification());

        $successResponse = [
            'status' => 'success',
            'message' => 'Password reset OTP has been sent to your email.',
        ];

        return response()->json($successResponse, 200);
    }
}
