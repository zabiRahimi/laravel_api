<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Admin as AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;



use Illuminate\Support\Str;


class AdminController extends Controller
{
    use AuthenticatesUsers;
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        // if (method_exists($this, 'hasTooManyLoginAttempts') &&
        //     $this->hasTooManyLoginAttempts($request)) {
        //     $this->fireLockoutEvent($request);

        //     return $this->sendLockoutResponse($request);
        // }

        if (! $this->attemptLogin($request)) {
            // return $this->sendLoginResponse($request);
            return 'okkkk';
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        // $this->incrementLoginAttempts($request);

        // return $this->sendFailedLoginResponse($request);
        return new AdminResource(auth()->guard('admin')->User());
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|exists:admins',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }







//     public function login(Request $request)
//     {
//     $val= $this->validate($request ,[
//         'email'=> 'required|email|exists:admins',
//         'password'=> 'required',
//     ]);
//     // $Admin = Admin::find(1);
//     // $Admin->update([
//     //     'rahimi.z1360@gmail.com',
//     //     'password' => bcrypt('zabi1360')
//     // ]);
//     // متد اَتمپت هم چک می کند که آیا کاربر لاگین کرده یا نه ، و هم اگر اطلاعات وارد شده صحیح باشد، کاربر را لاگین می کند
//     // $token = auth('api')->validate($val);
//     if (! auth('admin')->validate($val)) {
//         # code...
//         return response([
//             'data'=>'ایمیل یا رمز عبور صحیح نیست.',
//             'status' =>'error'
//         ],403);
//     }
//     //چنانچه بخواهیم کاربر فقط بتواند با یک دیوایس احراز هویت کند از دستور زیر استفاده می کنیم
//     // auth()->Admin()->update([
//     //     'api_token'=> Str::random(100)
//     // ]);
//     // Admin::find(auth()->Admin()->id)->update(
//     //     [
//     //         'api_token'=> Str::random(100)
//     //     ]);
//     // چون از متد اَتمپت برای چک کردن اطلاعات استفاده کردیم، در صورت صحیح بودن اطلاعات توسط دستور زیر اطالاعات کاربر لگین شده را دریافت می کنیم.
//     // return auth()->Admin();
//     auth()->guard('admin')->login($val);

//     return new AdminResource(auth()->guard('admin')->User());
// }

public function register(Request $request)
{
    $val= $this->validate($request ,[
        'name' => 'required|string|max:60',
        'email'=> 'required|string|email|max:255|unique:Admins',
        'password'=> 'required|string|min:6',
    ]);
    $Admin=Admin::create([
        'name' => $val['name'],
        'email' => $val['email'],
        'password' => bcrypt($val['password']),
        'api_token' => 'zabi'. Str::random(100),
    ]);
    return new AdminResource($Admin);
}
}
