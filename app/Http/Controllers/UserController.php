<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
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
        return view('usuarios.create');
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
}
