<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpVerified
{
    /**
     * Routes that should be excluded from this middleware
     */
    protected array $except = [
        'security.otp.show',
        'security.otp.verify',
        'security.otp.resend',
        'security.password.change',
        'security.password.submit',
        'logout',
        'login',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip if not authenticated
        if (!$user) {
            return $next($request);
        }

        // Skip for super admins
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Skip if route is in exception list
        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        // Skip if user doesn't require OTP verification
        if (!$user->requiresOtpVerification()) {
            return $next($request);
        }

        // Check if OTP was verified recently (within current session)
        if (!$user->hasVerifiedOtpRecently()) {
            // Store intended URL
            session()->put('url.intended', $request->url());

            return redirect()->route('security.otp.show')
                ->with('info', 'Please verify your identity with the code sent to your email.');
        }

        return $next($request);
    }

    protected function shouldSkip(Request $request): bool
    {
        $routeName = $request->route()?->getName();

        if (!$routeName) {
            return false;
        }

        return in_array($routeName, $this->except);
    }
}
