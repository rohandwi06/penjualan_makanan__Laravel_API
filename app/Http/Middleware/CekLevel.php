<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekLevel
{

    public function handle(Request $request, Closure $next): Response
    {

        if(auth()->check() && auth()->user()->role_id != 2) {
        //fungsi auth()->check() adalah untuk memastikan apakah user sudah login atau belum
            return response('Maaf, kamu tidak bisa mengakses halaman ini!', 403);
        }

        return $next($request);

    }
}
