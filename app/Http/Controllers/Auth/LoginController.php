<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\RolService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    protected $rolService;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/sisadmin/home';

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $request->session()->forget('ACCESOS');

        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'estado' => 'AC'  // Solo usuarios activos
        ];

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Guardar accesos en sesión
            $accesosUsuario = $this->rolService->getAllAccesosByUsuarioId($user->id);
            $accesos = collect($accesosUsuario)->pluck('codigo');
            $request->session()->put('ACCESOS', $accesos);

            return redirect($this->redirectTo);
        }

        // Registrar intento fallido
        $this->incrementLoginAttempts($request);

        // Verificar si el usuario existe
        $usuario = User::where('email', $request->input('email'))->first();

        if ($usuario && $usuario->estado === 'EL') {
            return back()->withInput()->withErrors([
                'email' => 'Su cuenta está inactiva. Comuníquese con el administrador del sistema.',
            ]);
        }

        // Mensaje genérico (por seguridad)
        return back()->withInput()->withErrors([
            'login' => 'Las credenciales ingresadas son incorrectas. Intente nuevamente.',
        ]);
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RolService $rolService)
    {
        $this->rolService = $rolService;
        $this->middleware('guest')->except('logout');
    }
}
