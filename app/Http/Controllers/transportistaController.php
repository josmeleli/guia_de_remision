<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\transportista;
use App\Models\agricultor;
use App\Models\Guia;
use App\Models\Pago;
use App\Models\Chofer;
use App\Models\Carga;
use App\Models\campo;
use Illuminate\Database\QueryException;

class transportistaController extends Controller

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
        return view('transportista.index', compact('guias','pagos','campos','transportistas','agricultores','cargas','choferes'));
    }
    
    public function store(Request $request)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'unidad_tecnica' => 'required',
                'campo' => 'nullable',
                'razon_social' => 'nullable',
                'codigo' => 'nullable',
                'nombre' => 'nullable',
                'RUC' => [
                    'required',
                    Rule::unique('transportistas')->where(function ($query) use ($request) {
                        return $query->where('RUC', $request->RUC);
                    }),
                ],
            ], [
                'RUC.unique' => 'El RUC ya está registrado.', // Mensaje personalizado para la regla unique
            ]);

            // Crear un nuevo objeto Transportista con los datos del formulario
            Transportista::create($validatedData);

            // Redireccionar a alguna vista después de guardar los datos
            return redirect()->route('mostrar.menu')->with('success', 'Transportista registrado exitosamente.');
        } catch (QueryException $e) {
            // Capturar excepciones de base de datos y manejarlas
            return redirect()->back()->with('error', 'Error al registrar el transportista: ' . $e->getMessage());
        }
    }

    

    public function update(Request $request, $id)
    {
        $transportista = transportista::findOrFail($id);
        $transportista->unidad_tecnica = $request->unidad_tecnica;
        $transportista->campo = $request->campo;
        $transportista->RUC = $request->RUC;
        $transportista->razon_social = $request->razon_social;
        $transportista->codigo = $request->codigo;
        $transportista->nombre = $request->nombre;
       

        // Guardar los cambios
        $transportista->save();

        // Redirigir de vuelta al formulario de edición con un mensaje de éxito
        return redirect()->back()->with('success', 'Trasportista actualizado correctamente');
    }

    public function destroy($id)
    {
        try {
            $transportista = transportista::findOrFail($id);
            $transportista->delete();
            
            return redirect()->back()->with('success', 'Transportista eliminado correctamente');
        } catch (\Exception $e) {
            // Manejo de errores si la guía no se encuentra o hay otros problemas
            return redirect()->back()->with('error', 'Error al eliminar transportista: ' . $e->getMessage());
        }
    }
}
