<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;

use App\Models\campo;
use Illuminate\Http\Request;
use App\Models\Guia;
use App\Models\Pago;
use App\Models\transportista;
use App\Models\agricultor;

class guiaController extends Controller
{
    public function index()
    {
        $totalGuias = Guia::count();
        $guiasPorEstado = [
            'Guía Facturada' => Guia::where('estado', 'guia_facturada')->count(),
            'Guía por Facturar' => Guia::where('estado', 'guia_por_facturar')->count(),
            'Factura Cancelada' => Guia::where('estado', 'factura_cancelada')->count(),
            'Factura por Cancelar' => Guia::where('estado', 'factura_por_cancelar')->count(),
        ];

        
        $guiasHoy = Guia::whereDate('fecha_emision', today())->count();

        $guiasPorEstadoConDetalles = [];

        foreach ($guiasPorEstado as $estado => $cantidad) {
            $guias = Guia::where('estado', $estado)->get();
            $guiasPorEstadoConDetalles[$estado] = $guias;
        }
        
        
       
        $guias = Guia::all();
        $pagos = Pago::all();
        $campos = campo::all();
        $agricultores = Agricultor::all();
        $agricultorId = optional(Agricultor::first())->id;
        $transportistaId = optional(Transportista::first())->id;
        $transportistas = transportista::all();
        return view('guia_remision.index', compact('guias','pagos','campos','transportistas','agricultorId','transportistaId','agricultores','totalGuias','guiasPorEstado','guiasHoy','guiasPorEstadoConDetalles'));
    }
    
    

    public function store(Request $request)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'fecha_emision' => 'required|date',
                'nro_guia' => 'required|unique:guias,nro_guia',
                'nro_ticket' => 'required',
                'fecha_partida' => 'required|date',
                'punto_partida' => 'required',
                'punto_llegada' => 'required',
                'producto' => 'required',
                'peso_bruto' => 'required',
                'estado' => 'required',
                'ruc_agricultor' => 'required',
                'ruc_transportista' => 'required',
            ]);

            // Obtener el ID del agricultor y del transportista
            $agricultorId = Agricultor::where('ruc', $request->ruc_agricultor)->value('id');
            $transportistaId = Transportista::where('RUC', $request->ruc_transportista)->value('id');
        
            // Verificar si se encontraron los IDs
            if (!$agricultorId || !$transportistaId) {
                return redirect()->back()->with('error', 'No se encontró un agricultor o transportista con el RUC proporcionado.');
            }
        
            // Asignar los IDs encontrados
            $validatedData['agricultor_id'] = $agricultorId;
            $validatedData['transportista_id'] = $transportistaId;

            // Crear una nueva instancia de GuiaRemision con los datos del formulario
            Guia::create($validatedData);

            // Redireccionar al usuario a la página deseada después de guardar la guía de remisión
            return redirect()->back()->with('success', '¡La guía de remisión se ha creado exitosamente!');
        } catch (QueryException $e) {
            // Capturar excepciones de base de datos y manejarlas
            return redirect()->back()->with('error', 'Error al guardar la guía de remisión: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Capturar otras excepciones y manejarlas
            return redirect()->back()->with('error', 'Error desconocido al guardar la guía de remisión: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        
    }

    
    public function update(Request $request, $id)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'fecha_emision' => 'required|date',
                'nro_guia' => 'required|unique:guias,nro_guia,'.$id,
                'nro_ticket' => 'required',
                'fecha_partida' => 'required|date',
                'punto_partida' => 'required',
                'punto_llegada' => 'required',
                'producto' => 'required',
                'peso_bruto' => 'required',
                'estado' => 'required',
                'ruc_agricultor' => 'required',
                'ruc_transportista' => 'required',
            ]);

            // Obtener el ID del agricultor y del transportista
            $agricultorId = Agricultor::where('ruc', $request->ruc_agricultor)->value('id');
            $transportistaId = Transportista::where('RUC', $request->ruc_transportista)->value('id');

            // Verificar si se encontraron los IDs
            if (!$agricultorId || !$transportistaId) {
                return redirect()->back()->with('error', 'No se encontró un agricultor o transportista con el RUC proporcionado.');
            }

            // Asignar los IDs encontrados
            $validatedData['agricultor_id'] = $agricultorId;
            $validatedData['transportista_id'] = $transportistaId;

            // Buscar la guía de remisión por su ID
            $guia = Guia::findOrFail($id);

            // Actualizar los datos de la guía de remisión
            $guia->update($validatedData);

            // Redireccionar al usuario a la página deseada después de actualizar la guía de remisión
            return redirect()->back()->with('success', '¡La guía de remisión se ha actualizado exitosamente!');
        } catch (QueryException $e) {
            // Capturar excepciones de base de datos y manejarlas
            return redirect()->back()->with('error', 'Error al actualizar la guía de remisión: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Capturar otras excepciones y manejarlas
            return redirect()->back()->with('error', 'Error desconocido al actualizar la guía de remisión: ' . $e->getMessage());
        }
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

    public function borrarSeleccionados(Request $request)
    {
        try {
            $guiaIdsString = $request->input('guia_ids');
            
            // Convertir la cadena de IDs en un array
            $guiaIds = explode(',', $guiaIdsString);
    
            // Verificar si se recibieron IDs de guías
            if (!empty($guiaIds)) {
                // Borrar las guías de remisión seleccionadas
                Guia::whereIn('id', $guiaIds)->delete();
    
                return redirect()->back()->with('success', 'Las guías de remisión seleccionadas se han borrado correctamente.');
            } else {
                return redirect()->back()->with('error', 'No se han seleccionado guías de remisión para borrar.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar borrar las guías de remisión seleccionadas: ' . $e->getMessage());
        }
    }

    public function verificarRuc(Request $request)
    {
        // Obtiene el RUC del parámetro de la solicitud
        $ruc = $request->get('ruc');

        // Busca un transportista con el RUC dado en la base de datos
        $transportista = Transportista::where('RUC', $ruc)->first();

        // Verifica si se encontró un transportista con el RUC dado
        if ($transportista) {
            // Si se encuentra, devuelve una respuesta JSON con 'registrado' como verdadero
            return response()->json(['registrado' => true]);
        } else {
            // Si no se encuentra, devuelve una respuesta JSON con 'registrado' como falso
            return response()->json(['registrado' => false]);
        }
    }

    public function buscarPorRUC(Request $request)
    {
        $ruc = $request->ruc;
        // Realiza la búsqueda en la base de datos por el RUC proporcionado
        $transportista = Transportista::where('ruc', $ruc)->first();

        if ($transportista) {
            return response()->json(['success' => true, 'transportista_id' => $transportista->id]);
        } else {
            return response()->json(['success' => false, 'error' => 'No se encontró ningún transportista con el RUC proporcionado.']);
        }
    }
    

}
