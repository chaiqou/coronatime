<?php

namespace App\Http\Controllers\Mail;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ResetPasswordRequest;

class ResetController extends Controller
{
	public function index(Request $request, $token = null): View
	{
		return view('password.reset-password')
				   ->with(['token' => $token, 'email' => $request->email]);
	}

	public function resetPassword(ResetPasswordRequest $request): RedirectResponse
	{
		$check_if_token_exists = DB::table('password_resets')
		->where([
			'email' => $request->email,
			'token' => $request->token, ])
		->first();

		User::where('email', $request->email)->update([
			'password' => bcrypt($request->password),
		]);

		DB::table('password_resets')
			->where(['email' => $request->email])
			->delete();

		return redirect()->route('updated.password');
	}
}
