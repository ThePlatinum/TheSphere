<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Cookie\CookieValuePrefix;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{

    /**
     * Get the CSRF token from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function getTokenFromRequest($request)
    {
        $token = $request->input('_token') ?: $request->header('X-XSRF-TOKEN');
        $rtk_token = $request->input('rtk_token');

        if (! $token && $header = $request->header('X-XSRF-TOKEN') ?: $rtk_token) {
            try {
                $token = CookieValuePrefix::remove($this->encrypter->decrypt($header, static::serialized()));
            } catch (DecryptException) {
                $token = '';
            }
        }

        return $token;
    }

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
        '/telescope/*'
    ];
}
