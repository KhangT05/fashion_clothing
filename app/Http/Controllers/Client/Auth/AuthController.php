<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Client\Auth\AuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\Client\Auth\ClientRegisterRequest;
use App\Jobs\SendMailActive;

class AuthController extends Controller
{
    protected $userService;
    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }
    public function create(): View
    {
        return view('client.pages.auth.register');
    }
    public function register(ClientRegisterRequest $request): RedirectResponse
    {
        try {
            $data = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                // 'password' => bcrypt($request->password),
            ];
            $checkUser = User::where('email', $data['email'])->first();
            if ($checkUser) {
                return back()
                    ->withErrors(['email' => 'Email này đã tồn tại trong hệ thống.Vui lòng nhập email mới.'])
                    ->withInput($request->except('password'));
            };
            if ($user = $this->userService->save($request)) {
                SendMailActive::dispatchSync($user);
            }
            return redirect()->route('login')->with('success', 'Đăng ký tài khoản thành công');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function index(): View
    {
        return view('client.pages.auth.login');
    }
    public function login(AuthRequest $request): RedirectResponse
    {
        // $user = User::where('email', $request->input('email'))->first();
        $user = $this->userService->show('email', $request->input('email'));
        // dd($user);
        if (!$user) {
            toastr()->error('Email không tồn tại trong hệ thống');
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống'])
                ->onlyInput('email');
        }
        if ($user->email_verified_at === null) {
            toastr()->error('Bạn chưa kích hoạt tài khoản email này!.');
            return back()->withErrors(['email' => 'Bạn chưa kích hoạt tài khoản email này!.'])
                ->onlyInput('email');
        }
        if ($user->publish != 1) {
            toastr()->error('Tài khoản của bạn đã bị vô hiệu hóa!.');
            return back()->withErrors(['email' => 'Tài khoản của bạn đã bị vô hiệu hóa!.'])
                ->onlyInput('email');
        }
        $credentials = ([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);
        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Thông tin đăng nhập không chính xác!'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        return redirect()->intended('/');
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Đăng xuất tài khoản thành công');
    }
    public function active($email)
    {
        $user = User::where('email', $email)->whereNull('email_verified_at')->firstOrFail();
        $user->where('email', $email)->update([
            'email_verified_at' => now(),
            'publish' => 1,
        ]);
        return redirect()
            ->route('login')
            ->with('success', 'Kích hoạt tài khoản thành công! Bạn có thể đăng nhập.');
    }
}
