<?php
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/auth/{provider}', [SocialController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialController::class, 'callback']);
class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'password' => bcrypt(uniqid()), // Dummy password
            ]
        );

        Auth::login($user, true);

        return redirect('/');
    }
}
