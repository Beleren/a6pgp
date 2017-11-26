<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed|regex:/^[a-z.]*(?=.{3,})(?=.{1,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/',
        ], [
            'name.required' => trans('paginas.registrar.name.required'),
            'name.string' => trans('paginas.registrar.name.string'),
            'name.max' => trans('paginas.registrar.name.max'),
            'name.min' => trans('paginas.registrar.name.min'),
            'email.required' => trans('paginas.registrar.email.required'),
            'email.string' => trans('paginas.registrar.email.string'),
            'email.email' => trans('paginas.registrar.email.formato'),
            'email.unique' => trans('paginas.registrar.email.unique'),
            'password.require' => trans('paginas.registrar.password.require'),
            'password.string' => trans('paginas.registrar.password.string'),
            'password.min' => trans('paginas.registrar.password.min'),
            'password.confirmed' => trans('paginas.registrar.password.confirmed'),
            'password.regex' => trans('paginas.registrar.password.regex'),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
