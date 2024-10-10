<?php

namespace App\Http\Controllers;  // Defines the namespace for the controller

use App\Models\User;  // Imports the User model
use Illuminate\Support\Facades\Auth;  // Imports the Auth facade for authentication
use Illuminate\Http\Request;  // Imports the Request class to handle HTTP requests

class AuthController extends Controller
{
    // Register user method
    public function register(Request $request)
    {
        // Validate incoming request data using the validate method
        $fields =  $request->validate([
            'userName' => ['required', 'max:255'],
            'email' => 'required|max:255|email|unique:users', //email field should be unique in each user table
            // 'password' field is required, must be at least 3 characters long, and requires confirmation
            // (meaning there should be another 'password_confirmation' field in the request)
            'password' => ['required', 'min:3', 'confirmed']
            // Note: 'confirmed' means Laravel will expect a matching 'password_confirmation' field in the form.
            // Also, Laravel automatically hashes the password if the field is named 'password'.
        ]);

        // Register the user by creating a new user record in the database using the validated fields
        $user =  User::create($fields);  // Here, `$fields` is an associative array with 'userName', 'email', and 'password'.

        // Log the user in automatically after registration using the Auth facade
        Auth::login($user);  // Auth::login() takes the newly created user and logs them in.

        // Redirect the user to the 'home' route after successful login
        return redirect()->route('posts.index');  // This redirects to a route named 'home', typically a dashboard or homepage.
    }

    public function login(Request $request)
    {
        // Validate
        $fields = $request->validate([
            'email' => ['required', 'max:225', 'email'],
            'password' => ['required']
        ]);

        // Try to login the user
        if (Auth::attempt($fields, $request->remember) //the remember is a bool value that makes the user be remembered and doesn't have to re login the next time they come to the webpage
        ) {
            return redirect()->intended(route('posts.index'));; //intended say they had timed out and were redirected back to login when trying to access dashboard they would be logged back to the intended page
        } else {
            return back()->withErrors([
                'failed' => "Te provided credentials do not match our records."
            ]);
        }
    }


    public function logout(Request $request)
    {
        // 1. Log the user out of the application (remove their authentication session).
        Auth::logout();

        // 2. Invalidate the user's session to prevent further access.
        // This ensures that all the session data for the user is cleared and no longer usable.
        $request->session()->invalidate();

        // 3. Regenerate the CSRF token.
        // After invalidating the session, a new CSRF token is generated for security reasons.
        // This helps prevent CSRF (Cross-Site Request Forgery) attacks by ensuring future requests use a fresh token.
        $request->session()->regenerateToken();

        // 4. Redirect the user to the login page after logging out.
        // You could also redirect them to a different page, like the homepage or a "Goodbye" page.
        return redirect('/login');
    }
}
