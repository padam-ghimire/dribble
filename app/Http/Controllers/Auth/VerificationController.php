<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Providers\RouteServiceProvider;

class VerificationController extends Controller
{
   
   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    public function verify(Request $request,User $user){
            if(! URL::hasValidSignature($request)){
                return response()->json(["errors"=>["message"=>"Invalid verifcation link"]],422);
            }

            if($user->hasVerifiedEmail($user)){
                return response()->json(["errors"=>["message"=>"Email already verified"]],422);
            }

            $user->markEmailAsVerified();
            event(new Verified($user));

            return response()->json(['message'=>"Email verified successfully"]);

    }

    public function resend(Request $request){

    }
}
