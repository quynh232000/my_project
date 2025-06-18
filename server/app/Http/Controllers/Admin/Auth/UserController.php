<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Requests\Admin\Auth\RegisterRequest;
use App\Models\Admin\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;


class UserController extends AdminController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    public function login()
    {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function _login(LoginRequest $request)
    {
        $user           = UserModel::where('email', $request->email)->first();
        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()->withInput()->with('error', 'Mật khẩu không đúng!');
        }

        auth()->login($user);

        $redirect_url   = session('redirect_url') ?? '/';
        session()->forget('redirect_url');
        return redirect($redirect_url)->with('success', 'Login sucessfully!');
    }
    public function register()
    {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function _register(RegisterRequest $request)
    {
        $user           = UserModel::where('email', $request->email)->first();
        $list_avatars   = [
            'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg',
            'https://img.freepik.com/free-psd/3d-illustration-bald-person-with-glasses_23-2149436184.jpg',
            'https://img.freepik.com/free-psd/3d-illustration-person-with-glasses_23-2149436191.jpg',
            'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436178.jpg'
        ];
        UserModel::insert([
            'uuid'          => Str::uuid(),
            'full_name'     => $request->full_name,
            'username'      => explode('@', $request->email)[0],
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'avatar'        => $list_avatars[rand(0, count($list_avatars) - 1)]
        ]);

        return redirect()->route('admin.auth.login')->with('success', 'Register sucessfully!');
    }
    public function reset_password()
    {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function new_password()
    {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function two_factor()
    {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.auth.login');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        $data           = Socialite::driver($provider)->stateless()->user();
        $email          = $data->user['email'];
        $checkUser      = UserModel::where('email', $email)->first();
        if ($checkUser) {
            auth()->login($checkUser);
        } else {
            if ($provider == 'google') {
                $avatar = $data->user['picture'];
                $username = explode('@', $data->user['email'])[0];
            } else {
                $avatar = $data->user['avatar_url'];
                $username = $data->nickname;
            }
            $newUser = UserModel::create([
                'uuid'              => Str::uuid(),
                'email'             => $email,
                'full_name'         => $data->user['name'],
                'avatar'            => $avatar,
                'username'          => $username,
            ]);
            auth()->login($newUser);
        }

        $redirect_url               = session('redirect_url') ?? '/';
        session()->forget('redirect_url');

        return redirect($redirect_url);
    }
}
