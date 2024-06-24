<?php

namespace App\Http\Controllers;
use App\Models\agricultor;
use App\Models\Guia;
use App\Models\Pago;
use App\Models\Chofer;
use App\Models\Carga;
use App\Models\Transportista;
use App\Models\campo;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class agricultorController extends Controller
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
        return view('agricultor.index', compact('guias','pagos','campos','transportistas','agricultores','cargas','choferes'));
    }
    

    public function store(Request $request)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'dni' => [
                    'required',
                    Rule::unique('agricultors')->where(function ($query) use ($request) {
                        return $query->where('dni', $request->dni);
                    }),
                ],
                'apellidos' => 'required',
                'nombres' => 'required',
                'ruc' => 'required|unique:agricultors,ruc',
                'razon_social' => 'required',
                'direccion' => 'required',
            ], [
                'dni.unique' => 'El DNI ya está registrado.', // Mensaje personalizado para la regla unique
                'ruc.unique' => 'El RUC ya está registrado.', // Mensaje personalizado para la regla unique
            ]);
    
            // Crear una nueva instancia de agricultor con los datos validados y guardarla en la base de datos
            Agricultor::create($validatedData);
    
            // Redireccionar de vuelta a la página del formulario con un mensaje de éxito
            return redirect()->route('mostrar.menu')->with('success', 'Agricultor registrado exitosamente.');
        } catch (\Exception $e) {
            // Capturar excepciones de base de datos y manejarlas
            return redirect()->back()->with('error', 'Error al registrar el agricultor: ' . $e->getMessage());
        }
    }
   
    public function update(Request $request, $id)
    {
        try {
            // Encontrar el agricultor por su ID
            $agricultor = Agricultor::findOrFail($id);
    
            // Actualizar los campos del agricultor con los datos del formulario
            $agricultor->nombres = $request->nombres;
            $agricultor->apellidos = $request->apellidos;
            $agricultor->dni = $request->dni;
            $agricultor->ruc = $request->ruc;
            $agricultor->razon_social = $request->razon_social;
            $agricultor->direccion = $request->direccion;
            // Actualiza los demás campos aquí...
    
            // Guardar los cambios
            $agricultor->save();
    
            // Redirigir de vuelta al formulario de edición con un mensaje de éxito
            return redirect()->back()->with('success', 'Agricultor actualizado correctamente');
        } catch (\Exception $e) {
            // Manejar excepciones si ocurre algún error
            return redirect()->back()->with('error', 'Error al actualizar el agricultor: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $agricultor = transportista::findOrFail($id);
            $agricultor->delete();
            
            return redirect()->back()->with('success', 'Agricultor eliminado correctamente');
        } catch (\Exception $e) {
            // Manejo de errores si la guía no se encuentra o hay otros problemas
            return redirect()->back()->with('error', 'Error al eliminar agricultor: ' . $e->getMessage());
        }
    }
}
