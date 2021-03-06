<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kbb;
use App\Services\MahasiswaService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $kbb = Kbb::all();
        $jurusan = Jurusan::all();
        return view('auth.register', compact('kbb', 'jurusan'));
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
            'nama' => ['required', 'string', 'max:60'],
            'email' => ['required', 'string', 'email', 'max:60', 'unique:users'],
            'nim' => ['required', 'numeric', 'digits:7', 'unique:mahasiswa'],
            'kbb_id' => ['required', 'exists:kbb,id'],
            'jurusan_id' => ['required', 'exists:jurusan,id'],
            'jen_kel' => ['required', Rule::in(config('constant.jen_kel'))],
            'no_hp' => ['required', 'alpha_num', 'max:13'],
            'tempat_lahir' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ], [], trans('login.attributes'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request, MahasiswaService $service)
    {
        $this->validator($request->all())->validate();

        if ($service->create($request->all())) {
            return redirect()->route('login')->with('flash_messages', [
                'type' => 'success',
                'message' => trans('login.register_success'),
            ]);
        }

        return redirect()->back()->with('flash_messages', [
            'type' => 'danger',
            'message' => trans('login.register_failed'),
        ]);
    }
}
