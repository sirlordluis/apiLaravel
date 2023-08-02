<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use Illuminate\Http\Request;

class DenunciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $denuncia = Denuncia::all();
        return response()->json($denuncia);
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
        // Validar los datos del formulario
        $request->validate([
            'numeroCentro' => 'required',
            'empresa' => 'required',
            'pais' => 'required',
            'estado' => 'required',
            'detalle' => 'required',
            'fecha' => 'required|date',
            'contrasena' => 'required',
            'status' => 'required',
            'fk_admin' => 'nullable|exists:administradors,id', // Verificar que el administrador exista si se proporciona su ID
        ]);

        // Generar automáticamente un número de folio de 5 dígitos
        //$ultimoFolio = Denuncia::max('folio');
        //$nuevoFolio = str_pad((int)$ultimoFolio + 1, 5, '0', STR_PAD_LEFT);
        
        $nuevoFolio = null;
        do {
            // Generar automáticamente un número de folio aleatorio de 5 dígitos
            $nuevoFolio = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);

            // Verificar si el número de folio generado ya existe en la base de datos
            $denunciaExistente = Denuncia::where('folio', $nuevoFolio)->first();
        } while ($denunciaExistente);

        // Crear una nueva instancia de Denuncia y asignar los valores del formulario
        $denuncia = new Denuncia();
        $denuncia->folio = $nuevoFolio;
        $denuncia->numeroCentro = $request->numeroCentro;
        $denuncia->empresa = $request->empresa;
        $denuncia->pais = $request->pais;
        $denuncia->estado = $request->estado;
        $denuncia->nombreDenunciante = $request->nombreDenunciante;
        $denuncia->correoDenunciante = $request->correoDenunciante;
        $denuncia->telefonoDenunciante = $request->telefonoDenunciante;
        $denuncia->detalle = $request->detalle;
        $denuncia->fecha = $request->fecha;
        $denuncia->contrasena = $request->contrasena;
        $denuncia->status = $request->status;

        // Verificar si se proporcionó el ID de administrador y establecer la relación
        if ($request->has('fk_admin')) {
            $denuncia->fk_admin = $request->fk_admin;
        }

        // Guardar la denuncia en la base de datos
        $denuncia->save();

        return response()->json(['message' => 'Denuncia creada satisfactoriamente', 'denuncia' => $denuncia]);
    }

    /**
     * Display the specified resource.
     */
    public function showByFolioOrId($idOrFolio)
    {
        // Verificar si el valor comienza con el prefijo "FOLIO_" o "F_"
        $isFolio = strpos($idOrFolio, 'FOLIO_') === 0 || strpos($idOrFolio, 'F_') === 0;

        if ($isFolio) {
            // Eliminar el prefijo del folio
            $folio = str_replace(['FOLIO_', 'F_'], '', $idOrFolio);
            
            $denuncia = Denuncia::where('folio', $folio)->first();
        } else {
            // Buscar por el ID
            $denuncia = Denuncia::find($idOrFolio);
        }

        if (!$denuncia) {
            return response()->json(['message' => 'No se encontró la denuncia con el ID o folio proporcionado.'], 404);
        }

        return response()->json($denuncia);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Denuncia $denuncia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Denuncia $denuncia)
    {
         // Valida los datos recibidos en la solicitud
        $request->validate([
            'numeroCentro' => 'required|integer',
            'empresa' => 'required|string',
            'pais' => 'required|string',
            'estado' => 'required|string',
            'nombreDenunciante' => 'nullable|string',
            'correoDenunciante' => 'nullable|email',
            'telefonoDenunciante' => 'nullable|string',
            'detalle' => 'required|string',
            'fecha' => 'required|date',
            'contrasena' => 'required|string',
            'status' => 'required|string'
        ]);

        // Actualiza los campos del modelo con los nuevos valores
        $denuncia->numeroCentro = $request->input('numeroCentro');
        $denuncia->empresa = $request->input('empresa');
        $denuncia->pais = $request->input('pais');
        $denuncia->estado = $request->input('estado');
        $denuncia->nombreDenunciante = $request->input('nombreDenunciante');
        $denuncia->correoDenunciante = $request->input('correoDenunciante');
        $denuncia->telefonoDenunciante = $request->input('telefonoDenunciante');
        $denuncia->detalle = $request->input('detalle');
        $denuncia->fecha = $request->input('fecha');
        $denuncia->contrasena = $request->input('contrasena');
        $denuncia->status = $request->input('status');
    
        // Verificar si se proporcionó el ID de administrador y establecer la relación
        if ($request->has('fk_admin')) {
            $denuncia->fk_admin = $request->fk_admin;
        } else {
            $denuncia->fk_admin = null; // Si no se proporciona el ID de administrador, establecerlo como nulo
        }
    
        // Guardar los cambios en la base de datos
        $denuncia->save();
    
        return response()->json(['message' => 'Denuncia actualizada satisfactoriamente', 'denuncia' => $denuncia]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Denuncia $denuncia)
    {
        $denuncia->delete();
    }
}
