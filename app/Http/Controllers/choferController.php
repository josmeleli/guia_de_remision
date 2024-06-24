<?php

namespace App\Http\Controllers;
use App\Models\Chofer;
use App\Models\Guia;
use App\Models\Pago;
use App\Models\transportista;
use App\Models\agricultor;
use App\Models\Carga;
use App\Models\campo;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

class choferController extends Controller
{
    public function index()
    {
        $guias = Guia::all();
        $choferes = Chofer::all();
        $cargas = Carga::all();
        $pagos = Pago::all();
        $agricultores = Agricultor::all();
        $campos = campo::all();
        $transportistas = transportista::all();
        return view('conductor.index', compact('guias','pagos','campos','transportistas','agricultores','cargas','choferes'));
    }
    
    public function store(Request $request)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'dni' => [
                    'required',
                    Rule::unique('chofers')->where(function ($query) use ($request) {
                        return $query->where('dni', $request->dni);
                    }),
                ],
                'nombre_apellidos' => 'required',
                'telefono' => 'required',
                'id_vehiculo' => 'required|exists:vehiculos,id',
            ], [
                'dni.unique' => 'El DNI ya está registrado.', // Mensaje personalizado para la regla unique
            ]);

            // Crear una nueva instancia de conductor con los datos validados y guardarla en la base de datos
            Chofer::create($validatedData);

            // Redireccionar de vuelta a la página del formulario con un mensaje de éxito
            return redirect()->route('mostrar.menu')->with('success', 'Conductor registrado exitosamente.');
        } catch (\Exception $e) {
            // Capturar excepciones de base de datos y manejarlas
            return redirect()->back()->with('error', 'Error al registrar el conductor: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        $chofer = Chofer::findOrFail($id);
        $chofer->dni = $request->dni;
        $chofer->nombre_apellidos = $request->nombre_apellidos;
        $chofer->telefono = $request->telefono;
        $chofer->id_vehiculo = $request->id_vehiculo;
       

        // Guardar los cambios
        $chofer->save();

        // Redirigir de vuelta al formulario de edición con un mensaje de éxito
        return redirect()->back()->with('success', 'Conductor actualizado correctamente');
    }

    public function destroy($id)
    {
        try {
            $guia = Chofer::findOrFail($id);
            $guia->delete();
            
            return redirect()->back()->with('success', 'Guía de remisión eliminada correctamente');
        } catch (\Exception $e) {
            // Manejo de errores si la guía no se encuentra o hay otros problemas
            return redirect()->back()->with('error', 'Error al eliminar la guía de remisión: ' . $e->getMessage());
        }
    }
}
