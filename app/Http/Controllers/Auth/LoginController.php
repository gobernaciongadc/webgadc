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
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $request->session()->forget('ACCESOS');

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $email = $request->input('email');
        $password = $request->input('password');
        $remember_me = $request->has('remember') ? true : false;
        if (Auth::attempt(['email' => $email, 'password' => $password, 'estado' => 'AC'],$remember_me)) {
            // The user is active, not suspended, and exists.

            //COLOCAMOS TODOS LOS ACCESOS DEL USUARIO
            $user = Auth::user();
            $accesosUsuario = $this->rolService->getAllAccesosByUsuarioId($user->id);
            $accesos = new Collection();
            foreach ($accesosUsuario as $acceso) {
                $accesos->push($acceso->codigo);
            }
            $request->session()->put('ACCESOS', $accesos);
            //Log::info($request->session()->get('ACCESOS'));

            return redirect($this->redirectTo);
        }
        else
        {
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            $usuario = User::where('email','=',$email)->first();
            if ($usuario) {
                if ($usuario->estado == 'EL') {
                    return back()->withInput()->withErrors([
                        'email' => 'Su cuenta esta inactiva, comuniquese con el administrador o encargado del sistema',
                    ]);
                }

            }
            else
            {
                return back()->withInput()->withErrors(['email'=>'La cuenta esta mal escrita o no existe, intente nuevamente por favor.']);
            }

            return back()->withInput()->withErrors(['password'=>'La cuenta o la contraseña estan mal escritos, vuelva a intentarlo por favor.']);
        }

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
