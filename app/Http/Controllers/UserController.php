<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
  //Show rgister form
  public function create()
  {
    return view('users.register');
  }
  //Store user in DB
  public function store(Request $request)
  {
    $fieldsForm = $request->validate([
      'name' => ['required', 'min:3'],
      'email' => ['required', Rule::unique('users', 'email')],
      'password' => 'required|confirmed|min:6'
    ]);
    // Hash password
    $fieldsForm['password'] = password_hash($fieldsForm['password'], PASSWORD_DEFAULT);

    //Create User
    $user = User::create($fieldsForm);
    //Login
    auth()->login($user);

    return redirect('/')->with('message', 'User create and logged in');
  }

  // Logout User
  public function logout(Request $request)
  {
    auth()->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('message', 'You have been logged out!');
  }

  // Show Login Form
  public function login()
  {
    return view('users.login');
  }

  // Authenticate User
  public function authenticate(Request $request)
  {
    $formFields = $request->validate([
      'email' => ['required', 'email'],
      'password' => 'required'
    ]);

    if (auth()->attempt($formFields)) {
      $request->session()->regenerate();

      return redirect('/')->with('message', 'You are now logged in!');
    }

    return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
  }
}
