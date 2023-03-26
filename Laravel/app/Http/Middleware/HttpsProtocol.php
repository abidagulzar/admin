<?php

namespace App\Http\Middleware;

use App\Models\Unit;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class HttpsProtocol
{
    public function handle($request, Closure $next)
    {
        $request->setTrustedProxies([$request->getClientIp()], Request::HEADER_X_FORWARDED_ALL);

        if (!$request->secure() && App::environment() === 'production') {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
