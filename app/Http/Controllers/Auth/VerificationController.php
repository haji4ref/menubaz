<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VerificationController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Mark the user's email address as verified.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User                $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $user = auth()->user();
        if($request->get('verification_code') === $user->verification_code) {
            $user->makeVerified();

            return response()->json([
                'status' => trans('verification.verified'),
            ]);
        } else
            return response()->json([
                'status' => 'کد هویت درست نیست.'
            ], 400);
    }

    /**
     * Resend the email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if(is_null($user)) {
            throw ValidationException::withMessages([
                'email' => [trans('verification.user')],
            ]);
        }

        if($user->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => [trans('verification.already_verified')],
            ]);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['status' => trans('verification.sent')]);
    }
}
