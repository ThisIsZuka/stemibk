<?php

namespace App\Http\Controllers\Auth;

use Mail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Hash;
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
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function store(Request $request){
        $this->create($request->post());
		$this->sendemail($request->post());
		
		redirect('/Login');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
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
            'name'      => $data['prefixname'].$data['firstname'].$data['lastname'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'user_type' => 'student',
            'prefixname' => $data['prefixname'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'position' => $data['position'],
            'department_sub' => $data['department_sub'],
            'department_main' => $data['department_main'],
            'department_tel' => $data['department_tel'],
            'mobile' => $data['mobile'],
            'phone' => $data['mobile'],
            'line' => $data['line'],
            'department_address' => $data['department_address'],
            'experience' => $data['experience'],
            'job_format' => $data['job_format'],
        ]);

    }
	protected function sendemail(array $data)
	{
        return Mail::send('emails', $data, function($message) use ($data)
        {
            $message->from('no-reply@thammasat.com', "Bioplus Thammasat");
            $message->subject("Registation");
            $message->to($data['email']);
        });		
	}
}
