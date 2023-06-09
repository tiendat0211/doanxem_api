<?php

namespace App\Http\Controllers\Auth;


//use App\Http\Controllers\Controller;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\SocialAccount;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{
    const DRIVER_TYPE = 'facebook';
    const DRIVER_TYPE_GOOGLE = 'google';
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        $request->remember = $request->remember == 'on' ? true : false;

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }
    public function callback($social)
    {
        $socialUser = Socialite::driver($social)->user();
        $user = null;

        DB::transaction(function () use ($socialUser,$social,&$user) {
            $socialAccount = SocialAccount::firstOrNew([
                'social_id' => $socialUser->getId(),
                'social_provider' => $social,
            ],[
                'social_name' => $socialUser->getName()
            ]);
            if (!($user = $socialAccount->user)) {
                if (!($user = User::where('email',$socialUser->getEmail())->first())) {
                    $user = User::create([
                        'email' => $socialUser->getEmail(),
                        'name' => $socialUser->getName(),
                        'password' => Hash::make('sPhoton123'),
                        'email_verified_at' => Carbon::now(),
                        'avatar' => $socialUser->getAvatar(),
                        'user_uuid' => Str::uuid()
                    ]);
                }
                if (!$user->email_verified_at) {
                    $user->fill(['email_verified_at' => Carbon::now()])->save();
                }
                $socialAccount->fill(['user_id' => $user->id])->save();
            }
        });

        Auth::login($user);

        return redirect()->route('home');
    }
}

