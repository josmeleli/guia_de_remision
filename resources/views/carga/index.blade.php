@extends('layouts.sidebar')

@extends('layouts.header')
<!-- Aquí puedes agregar tu formulario, tabla u otro contenido -->




@section('content')

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Cargas</h3>
        </div>

        <div class="card-body p-2">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Conductor</th>
                        <th>Carga Bruta</th>
                        <th>Carga Neta</th>
                        <th>Material Extraño</th>
                        <th>Km Origen</th>
                        <th>Km Destino</th>
                        <th>Fecha Carga</th>
                        <th>Fecha Descarga</th>
                        <th>Acciones</th>
                        
                    </tr>

                </thead>
                <tbody>
                    @foreach ($cargas as $carga)
                        <tr>
                            <td>{{ $carga->id }}</td>
                            <td>{{ $carga->id_conductor }}</td>
                            <td>{{ $carga->total_carga_bruta }}</td>
                            <td>{{ $carga->total_carga_neta }}</td>
                            <td>{{ $carga->total_material_extrano }}</td>
                            <td>{{ $carga->km_origen }}</td>
                            <td>{{ $carga->km_de_destino }}</td>
                            <td>{{ $carga->fecha_carga }}</td>
                            <td>{{ $carga->fecha_de_descarga }}</td>
                            
                            
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $carga->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                      </svg>
                                </button>
                                <div class="modal fade" id="editModal{{ $carga->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $carga->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title" id="editModalLabel{{ $carga->id }}">Editar Conductor</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Formulario para editar la guía de remisión -->
                                                <form id="editForm{{ $carga->id }}" action="{{ route('carga.update', $carga->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Campos para editar -->
                                                    <div class="form-group row">
                                                        <div class="col-md-6 ">
                                                            <label for="id_conductor">ID Conductor:</label>
                                                            <input type="number" class="form-control" id="id_conductor" name="id_conductor" value="{{ $carga->id_conductor }}" required>
    
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="total_carga_bruta">Total de Carga Bruta: </label>
                                                            <input type="number" class="form-control" id="total_carga_bruta" name="total_carga_bruta" value="{{ $carga->total_carga_bruta    }}" required>
    
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6 ">
                                                            <label for="total_carga_neta">Total de Carga Neta:</label>
                                                            <input type="number" class="form-control" id="total_carga_neta" name="total_carga_neta" value="{{ $carga->total_carga_neta }}" required>
    
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="total_material_extrano">Material Extraño: </label>
                                                            <input type="number" class="form-control" id="total_material_extrano" name="total_material_extrano" value="{{ $carga->total_material_extrano }}" required>
                                                            
    
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6 ">
                                                            <label for="km_origen">Km de Origen:</label>
                                                            <input type="number" class="form-control" id="km_origen" name="km_origen" value="{{ $carga->km_origen }}" required>
    
                                                        </div>
                                                        <div class="col-md-6 ">
                                                            <label for="km_de_destino">Km de Destino:</label>
                                                            <input type="number" class="form-control" id="km_de_destino" name="km_de_destino" value="{{ $carga->km_de_destino }}" required>
    
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6 ">
                                                            <label for="fecha_carga">Fecha de Carga:</label>
                                                            <input type="date" class="form-control" id="fecha_carga" name="fecha_carga" value="{{ $carga->fecha_carga }}" required>
    
                                                        </div>
                                                        <div class="col-md-6 ">
                                                            <label for="fecha_de_descarga">Fecha de Descarga:</label>
                                                            <input type="date" class="form-control" id="fecha_de_descarga" name="fecha_de_descarga" value="{{ $carga->fecha_de_descarga }}" required>
    
                                                        </div>
                                                       
                                                    </div>
                                                   
                                               
                                                    <!-- Agrega aquí más campos para editar -->
                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('carga.destroy', $carga->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M4 7l16 0" />
                                            <path d="M10 11l0 6" />
                                            <path d="M14 11l0 6" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                          </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>
        
    </div>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/styleTables.css') }}">
@endsection