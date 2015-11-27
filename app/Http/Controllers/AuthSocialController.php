<?php namespace Tasks\Http\Controllers;

//use Illuminate\Routing\Controller;
use Socialite;
use Auth;
use Input;
use Tasks\Db\User;

class AuthSocialController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        //Socialize::driver('twitter')->redirect();
        //$HybridAuth = new HybridAuth();

    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $provider  = Input::get('provider');
        $socialite = Socialite::driver($provider)->user();        
        
        $userData  = User::where('provider_id', $socialite->id)->first();
        
        if (!$userData) {
            $userData = User::firstOrCreate([
                'provider_id' => $socialite->id,
                'provider' => $provider,
                'name' => $socialite->name,
                'username' => $socialite->nickname,
                'password' => $socialite->id,
                'email' => $socialite->email,
                'avatar' => $socialite->avatar,
                ]);        
        } 

        Auth::login($userData, true);

        return redirect()->intended('profile');
    }
    
}
