<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campo;
use App\Models\Guia;
use App\Models\Pago;
use App\Models\transportista;
use App\Models\agricultor;
use App\Models\Carga;

class campoController extends Controller
{
    public function index()
    {
        $guias = Guia::all();
        $cargas = Carga::all();
        $pagos = Pago::all();
        $agricultores = Agricultor::all();
        $campos = campo::all();
        $transportistas = transportista::all();
        return view('campo.index', compact('guias','pagos','campos','transportistas','agricultores','cargas'));
    }
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'acopiadora' => 'required|string',
            'ubigeo' => 'required|string',
            'zona' => 'required|string',
            'ingenio' => 'required|string',
            'carga_id' => 'required|exists:cargas,id',
            'agricultor_id' => 'required|exists:agricultors,id',
        ]);

        // Crear un nuevo campo
        Campo::create([
            'acopiadora' => $request->acopiadora,
            'ubigeo' => $request->ubigeo,
            'zona' => $request->zona,
            'ingenio' => $request->ingenio,
            'carga_id' => $request->carga_id,
            'agricultor_id' => $request->agricultor_id,
        ]);

        // Redireccionar a una ruta después de guardar el campo (opcional)
        return redirect()->route('mostrar.menu')->with('success', '¡El campo ha sido registrado correctamente!');
    }

    

    public function destroy($id)
    {
        try {
            $guia = Guia::findOrFail($id);
            $guia->delete();
            
            return redirect()->back()->with('success', 'Guía de remisión eliminada correctamente');
        } catch (\Exception $e) {
            // Manejo de errores si la guía no se encuentra o hay otros problemas
            return redirect()->back()->with('error', 'Error al eliminar la guía de remisión: ' . $e->getMessage());
        }
    }
    

}
