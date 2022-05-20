<?php

namespace App\Http\Controllers\Mail;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class ResetController extends Controller
{
	public function index(Request $request, $token = null): View
	{
		return view('password.reset-password')->with(['token' => $token, 'email' => $request->email]);
	}

	public function updatedPassword(): View
	{
		return view('password.updated-password');
	}

	public function resetPassword(Request $request): RedirectResponse
	{
		$request->validate([
			'email'                 => 'required|email',
			'password'              => 'required|confirmed|min:3',
			'password_confirmation' => 'required',
		]);

		$check_token = DB::table('password_resets')->where([
			'email' => $request->email,
			'token' => $request->token,
		])->first();

		// if values dont match redirect back if match update user password
		if (!$check_token)
		{
			return back();
		}
		else
		{
			User::where('email', $request->email)->update([
				'password' => Hash::make($request->password),
			]);

			DB::table('password_resets')->where([
				'email' => $request->email,
			])->delete();

			return redirect('/updated-password');
		}
	}
}