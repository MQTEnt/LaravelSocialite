<?php

namespace App\Http\Controllers;

use Socialite;
use Illuminate\Http\Request;
use App\User;
use Auth;
class FacebookController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $userFacebook = Socialite::driver('facebook')->user();
        //dd($userFacebook);
        $user_current = User::where('facebook_id', $userFacebook->id)->first();
        if(is_null($user_current))
        {
            $user = new User();
            $user->name = $userFacebook->name;
            $user->email = $userFacebook->email;
            $user->facebook_id = $userFacebook->id;
            $user->save();
            Auth::login($user, true);
        }
        else
        {
            Auth::login($user_current, true);
            echo $user_current->name;
        }
    }
}