<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,svg', 'max:4096'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $file = $data['image'];
        $imgFile = Image::make($file->getRealPath());
        $destinationPath = 'uploads/';

        $filename = $data['name'] . "_" . Carbon::now() . "." . $file->getClientOriginalExtension();
        $filename = str_replace(':', '_', $filename);
        $filename = str_replace(' ', '_', $filename);
        $imgFile->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $filename);
        return User::create([
            'name' => $data['name'],
            'role' => 'customer',
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'image' => $filename,
        ]);
    }
}
