<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Muestra el formulario para crear un nuevo usuario.
     *
     * Este método retorna la vista correspondiente al formulario donde se
     * podrá ingresar la información necesaria para crear un nuevo usuario.
     *
     * @return \Illuminate\View\View La vista que contiene el formulario de creación de usuarios.
     */

    public function create()
    {
        return view('usuarios.auth.create');
    }

    /**
     * Crea un nuevo usuario en la base de datos.
     *
     * Este método recibe los datos validados a través de la clase UserRequest,
     * inicia una transacción, crea el usuario en la base de datos y guarda su contraseña
     * de manera segura utilizando `Hash::make()`. En caso de que ocurra un error durante el
     * proceso, se realiza un rollback de la transacción y se registra el error en los logs.
     *
     * @param \App\Http\Requests\UserRequest $request El objeto de solicitud que contiene los datos validados del usuario.
     *
     * @return \Illuminate\Http\RedirectResponse Redirige de nuevo con un mensaje de éxito o error.
     *
     * @throws \Exception Si ocurre un error durante la creación del usuario.
     */
    public function store(UserRequest $request)
    {
        try {
            // Iniciamos la transacción para generar el registro.
            DB::beginTransaction();

            // Creamos un nuevo usuario:
            $usuario = new User();
            $usuario->name = strtolower($request->name);
            $usuario->email = strtolower($request->email);
            $usuario->password = Hash::make($request->password);
            $usuario->save();

            // Si todo sale bien hacemos el commit de la transacción.
            DB::commit();

            // Redirigimos a una vista diferente con el mensaje de éxito.
            return redirect()->back()->with('success', 'Usuario creado con éxito.');
        } catch (\Exception $e) {
            // Si algo falla hacemos el rollback de la transacción.
            DB::rollBack();

            // Registramos el error en el log con más contexto.
            Log::error("Error al crear el usuario con email {$request->email}: {$e->getMessage()}");

            // Volvemos al formulario e informamos que algo salió mal.
            return redirect()->back()->with('error', 'Ocurrió un error al crear el usuario.');
        }
    }

    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return \Illuminate\View\View
     */
    public function formularioLogin()
    {
        return view('usuarios.auth.login');
    }

    /**
     * Maneja la solicitud de inicio de sesión.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            // Obtenemos las credenciales
            $credenciales = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            // Intentamos autenticar al usuario
            if (Auth::attempt($credenciales)) {
                // Autenticacion exitosa:
                return redirect()->route('home')->with('success', 'Inicio de sesión exitoso.');
            }

            // Si la autenticacion falla verificamos que credencial es la incorrecta
            $user = User::where('email', $request->emal)->first();

            if ($user) {
                // El email es correcto, pero la contraseña es incorrecta
                return redirect()->back()->withErrors([
                    'password' => 'La contraseña es incorrecta.'
                ]);
            } else {
                // El email no existe
                return redirect()->back()->withErrors([
                    'email' => 'El correo electrónico no está registrado.'
                ]);
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * Cierra la sesión del usuario.
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Cierre de sesión exitoso.');
    }
}
