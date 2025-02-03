<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use App\Mail\ActivationMail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'activation_code' => mt_rand(100000, 999999),
        ]);

        //$user->assignRole("CLIENT");

        //Envoie du code d'activation
        Mail::to($user->email)
            ->queue(new ActivationMail($user));

        $userId=$user->id;

        //Auth::login($user);
        flash()->success('Task completed successfully.');
        return view('auth.confirm-code',compact('userId'))->with('success', "Le code d'activation est envoyé par mail !");
    }

    
    public function activation(Request $request)
    {
        $user=User::find($request->user);
        if ($user && $user->activation_code==$request->activation_code) {
            $user->update([
                'is_active'=>true,
                'email_verified_at'=>date('Y-m-d')
            ]);
            return redirect('dashboard')->with('success', "Votre compte est activé avec succès !");
        } else {
            $userId=$user->id;
            flash()->error("Le code n'est pas correcte !");
            return view('auth.confirm-code',compact('userId'));
            return redirect('activation',compact('user'));
        }
    }
}
