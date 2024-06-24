<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carga;
use App\Models\Chofer;
use App\Models\Guia;
use App\Models\Pago;
use App\Models\agricultor;
use App\Models\campo;
use App\Models\transportista;

class cargaController extends Controller
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
        return view('carga.index', compact('guias','pagos','campos','transportistas','agricultores','cargas','choferes'));
    }
    

   

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'id_conductor' => 'required|exists:chofers,id',
            'total_carga_bruta' => 'required',
            'total_carga_neta' => 'required',
            'total_material_extrano' => 'required',
            'km_origen' => 'required',
            'km_de_destino' => 'required',
            'fecha_carga' => 'required|date',
            'fecha_de_descarga' => 'required|date',
        ]);

        // Crear una nueva instancia de carga con los datos validados y guardarla en la base de datos
        Carga::create($validatedData);

        // Redireccionar de vuelta a la página del formulario con un mensaje de éxito
        return redirect()->route('mostrar.menu')->with('success', 'Carga registrada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $carga = Carga::findOrFail($id);
        $carga->id_conductor = $request->id_conductor;
        $carga->total_carga_bruta = $request->total_carga_bruta;
        $carga->total_carga_neta = $request->total_carga_neta;
        $carga->total_material_extrano = $request->total_material_extrano;
        $carga->km_origen = $request->km_origen;
        $carga->km_de_destino = $request->km_de_destino;
        $carga->fecha_carga = $request->fecha_carga;
        $carga->fecha_de_descarga = $request->fecha_de_descarga;
       

        // Guardar los cambios
        $carga->save();

        // Redirigir de vuelta al formulario de edición con un mensaje de éxito
        return redirect()->back()->with('success', 'Carga actualizada correctamente');
    }

    public function destroy($id)
    {
        try {
            $carga = transportista::findOrFail($id);
            $carga->delete();
            
            return redirect()->back()->with('success', 'Carga eliminada correctamente');
        } catch (\Exception $e) {
            // Manejo de errores si la guía no se encuentra o hay otros problemas
            return redirect()->back()->with('error', 'Error al eliminar carga: ' . $e->getMessage());
        }
    }
}
