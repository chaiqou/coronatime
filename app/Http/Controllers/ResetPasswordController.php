<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
	// show reset password page
	public function create(Request $request, $token = null)
	{
		return view('password.reset-password')->with(['token' => $token, 'email' => $request->email]);
	}

	// show updated password page
	public function updatedPassword()
	{
		return view('password.updated-password');
	}

	// reset password
	public function store(Request $request)
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