<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users with ArcGIS Online
    | Once authenticated, the user is created if not already in DB and logged in
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect user to ArcGIS Auth Page
     *
     * @return \Illuminate\Http\Respoonse
     */
    public function redirectToProvider()
    {
        return Socialite::with('arcgis')->redirect();
    }

    /**
     * Obtain the user information from GitHub
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('arcgis')->user();

        if($user and $user->user) {
            $authUser = $this->findOrCreate($user->user);
            if(!$authUser) {
                return redirect('/')
                    ->withErrors(['Not a member of correct ArcGIS Org']);
            }
            Auth::login($authUser, true);
            return redirect($this->redirectTo);
        }  else {
            return redirect('/')
                ->withErrors(['Invalid content passed from ArcGIS']);
        }

    }

    /**
     * If user already in system, return user
     * otherwise, return new user
     * @return \App\User
     */
    public function findOrCreate($user)
    {
        if($user['orgId'] !== env('ARCGIS_ORG_ID')) {
            return false;
        }

        function getUserDetails($user) {
            return array(
                'fullName' => $user['fullName'],
                'role' => $user['role'],
                'level' => $user['level'],
                'thumbnail' => $user['thumbnail']
            );
        }

        $authUser = User::where('name', $user['username'])->first();
        if($authUser)
        {
            $authUser->details = json_encode(getUserDetails($user));
            $authUser->save();
            return $authUser;
        }

        return User::create([
            'name' => $user['username'],
            'email' => $user['email'],
            'details' => json_encode(getUserDetails($user))
        ]);
    }
}
