<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use dateTimeZone;
use App\User as User;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->input('token') !== null) {
            $user = User::where('token', $request->input('token'))->get()->first();
            if($user !== null) {
                $expirationToken = $user->token_expiration;
                $currentDate = new DateTime('', new DateTimeZone('Europe/Paris'));
                if($expirationToken > $currentDate->format('Y-m-d H:i:s')) {
                    return $next($request);
                }
            }
        }
        return response()->json([
            'error' => 'Authentication error',
            'errorMessage' => 'Please reconnect'
        ]);
    }
}
