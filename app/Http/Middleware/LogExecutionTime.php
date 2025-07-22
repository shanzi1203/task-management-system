<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;


class LogExecutionTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $start=microtime(true);
        $response=$next($request);
        $end=microtime(true);
        $executionTime=round($end-$start,3);
        Log::info('[' . $request->method() . '] ' . $request->fullUrl() . ' - Execution Time: ' . $executionTime . ' seconds');
        return $response;
    }
}
