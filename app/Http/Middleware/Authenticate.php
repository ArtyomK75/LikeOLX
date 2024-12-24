<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{

//    protected function redirectTo(Request $request, Closure $next, ...$guards): ?string
//    {
//        if (!$request->expectsJson()) {
//            abort(404);
//        }
//        if ($request->REQUEST_URI === "/api/adverts"
//            && $request->SCRIPT_NAME === "/index.php") {
//            return $next($request);
//        }
//        return response()->json(['message' => 'Unauthorized'], 401);
//    }

//    public function handle($request, Closure $next, ...$guards): ?string
//    {
//        if (!$request->expectsJson()) {
//            abort(404);
//        }
//        if ($request->isMethod('GET')) {
//            return $next($request);
//        }
//
//        return response()->json(['message' => 'Unauthorized'], 401);
//    }

}
