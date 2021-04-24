<?php

namespace App\Http\Controllers\Api\v1;

// use App\Models\User;
use App\Http\Resources\v1\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // $user = User::find(1);
        // $user->update([
        //     'email' => 'rahimi.z1360@gmail.com',
        //     'password' => bcrypt('zabi1360')
        // ]);
        #validate
       $val= $this->validate($request ,[
            'email'=> 'required|email|exists:users',
            'password'=> 'required',
        ]);
        // $user = User::find(1);
        // $user->update([
        //     'rahimi.z1360@gmail.com',
        //     'password' => bcrypt('zabi1360')
        // ]);
        // متد اَتمپت هم چک می کند که آیا کاربر لاگین کرده یا نه ، و هم اگر اطلاعات وارد شده صحیح باشد، کاربر را لاگین می کند
        if (! Auth::attempt($val)) {
            # code...
            return response([
                'data'=>'ایمیل یا رمز عبور صحیح نیست.',
                'status' =>'error'
            ],403);
        }
        //چنانچه بخواهیم کاربر فقط بتواند با یک دیوایس احراز هویت کند از دستور زیر استفاده می کنیم
        // auth()->user()->update([
        //     'api_token'=> Str::random(100)
        // ]);
        // User::find(auth()->user()->id)->update(
        //     [
        //         'api_token'=> Str::random(100)
        //     ]);
        // چون از متد اَتمپت برای چک کردن اطلاعات استفاده کردیم، در صورت صحیح بودن اطلاعات توسط دستور زیر اطالاعات کاربر لگین شده را دریافت می کنیم.
        // return auth()->user();

        return new UserResource(auth()->user());
    }

    public function register(Request $request)
    {
        $val= $this->validate($request ,[
            'name' => 'required|string|max:60',
            'email'=> 'required|string|email|max:255|unique:users',
            'password'=> 'required|string|min:6',
        ]);
        $user=User::create([
            'name' => $val['name'],
            'email' => $val['email'],

            'password' => bcrypt($val['password']),


        ]);
        return new UserResource($user);
    }
}
