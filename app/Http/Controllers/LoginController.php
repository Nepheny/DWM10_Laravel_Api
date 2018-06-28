<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User as User;
use DateTime;
use DateTimeZone;
use DateInterval;

class LoginController extends Controller
{
    public function logout(Request $request)
    {
        if($request->input('token') !== null) {
            $user = User::where('token', $request->input('token'))->get()->first();
            if($user !== null) {
                $user->token = null;
                $user->token_expiration = null;
                $user->save();
                return response()->json([
                    'success' => 'Logout successfull',
                    'successMessage' => ''
                ]);
            }
        }
        return response()->json([
            'error' => 'Logout unsuccessfull',
            'errorMessage' => ''
        ]);
    }

    public function login(Request $request)
    {
        if($request->input('name') !== null && $request->input('password') !== null) {
            $user = User::where('name', $request->input('name'))->get()->first();
            if($user !== null) {
                if(Hash::check($request->input('password'), $user->password) === true) {
                    while (true) {
                        $authToken = str_random(60);
                        if(User::where('token', $authToken)->get()->first() == null) {
                            break;
                        }
                    }
                    $user->token = $authToken;
                    $expirationToken = new DateTime('', new DateTimeZone('Europe/Paris'));
                    $expirationToken->add(new DateInterval(env('CONNECTION_TOKEN_EXPIRATION', 'PT1H')));
                    $user->token_expiration = $expirationToken->format('Y-m-d H:i:s');
                    $user->save();
                    return response()->json([
                        'success' => 'Authentication successfull',
                        'successMessage' => $user->token
                    ]);
                }
            }
        }
        return response()->json([
            'error' => 'Authentication error',
            'errorMessage' => ''
        ]);
    }
}
