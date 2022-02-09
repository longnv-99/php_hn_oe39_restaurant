<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUserRequest;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

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
    protected $userRepo;
    protected $imageRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserRepositoryInterface $userRepo,
        ImageRepositoryInterface $imageRepo
    ) {
        $this->middleware('guest');
        $this->userRepo = $userRepo;
        $this->imageRepo = $imageRepo;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = $this->userRepo->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_active' => config('app.is_active'),
            'role_id' => config('app.user_role_id'),
            'fullname' => $data['fullname'],
            'dob' => $data['dob'],
        ]);

        $this->imageRepo->create([
            'path' => config('app.default_avatar_path'),
            'imageable_type' => get_class($user),
            'imageable_id' => $user->id,
        ]);
    }

    public function register(RegisterUserRequest $request)
    {
        $this->create($request->all());

        return redirect('login')->with('message', __('messages.register_success'));
    }
}
