<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Modules\Core\Facades\ReCaptcha;
use Modules\Core\Rules\ValidRecaptchaRule;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails {
        SendsPasswordResetEmails::sendResetLinkEmail as mainSendResetLinkEmail;
        SendsPasswordResetEmails::showLinkRequestForm as mainshowLinkRequestForm;
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        if (forgot_password_is_disabled()) {
            abort(404);
        }

        return $this->mainshowLinkRequestForm();
    }

    /**
     * Send a reset link to the given user.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        if (forgot_password_is_disabled()) {
            abort(404);
        }

        return $this->mainSendResetLinkEmail($request);
    }

    /**
     * Validate the email for the given request.
     *
     *
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(array_merge([
            'email' => 'required|email',
        ], ReCaptcha::shouldShow() ? ['g-recaptcha-response' => ['required', new ValidRecaptchaRule]] : []));
    }
}
