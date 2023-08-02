<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Denuncia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $administrador = Administrador::all();
        return response()->json($administrador);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customMessages = [
            'email.unique' => 'El correo electrónico ya está registrado por otro administrador.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El campo correo electrónico debe ser una dirección de correo válida.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ];

        // Validar los datos del request
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('administradors'),
            ],
            'password' => 'required',
        ], $customMessages);

        // Crear un nuevo administrador
        $administrador = new Administrador();
        $administrador->email = $request->email;
        $administrador->password = $request->password;
        $administrador->save();

        return response()->json($administrador);
    }

    /**
     * Display the specified resource.
     */
    public function show(Administrador $administrador)
    {
        return response()->json($administrador);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Administrador $administrador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Administrador $administrador)
    {
         // Definir mensajes personalizados para las validaciones
        $customMessages = [
            'email.unique' => 'El correo electrónico ya está registrado por otro administrador.',
            'required' => 'El campo :attribute es obligatorio.',
        ];

        // Validar los datos del request
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('administradors')->ignore($administrador->id),
            ],
            'password' => 'required',
        ], $customMessages);

        // Actualizar los datos del administrador
        $administrador->email = $request->email;
        $administrador->password = $request->password;
        $administrador->save();

        $data = [
            'message' => 'Administrador actualizado satisfactoriamente',
            'administrador' => $administrador,
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrador $administrador)
    {
        $administrador->delete();
    }


    public function attach($id){
        $administrador = Administrador::find($id);

        if (!$administrador) {
            return response()->json(['message' => 'Administrador no encontrado.'], 404);
        }

        $denuncias = Denuncia::where('fk_admin', $administrador->id)->first();

        return response()->json($denuncias);
    }

    public function busqueda($email) {
        // Utiliza el método first() para obtener el primer resultado o null si no se encuentra
        $administrador = Administrador::where('email', $email)->first();

        if (!$administrador) {
            return response()->json(['message' => 'Administrador no encontrado.'], 404);
        }

        // Retorna todos los campos del administrador como una respuesta JSON
        return response()->json($administrador);
    }
}
