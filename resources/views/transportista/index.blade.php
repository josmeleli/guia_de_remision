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
            <h3 class="card-title">Lista de Transportistas</h3>
        </div>

        <div class="card-body p-2">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Unidad Tecnica</th>
                        <th>Campo</th>
                        <th>RUC</th>
                        <th>Razon Social</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                        
                    </tr>

                </thead>
                <tbody>
                    @foreach ($transportistas as $transportista)
                        <tr>
                            <td>{{ $transportista->id }}</td>
                            <td>{{ $transportista->unidad_tecnica }}</td>
                            <td>{{ $transportista->campo }}</td>
                            <td>{{ $transportista->RUC }}</td>
                            <td>{{ $transportista->razon_social }}</td>
                            <td>{{ $transportista->codigo }}</td>
                            <td>{{ $transportista->nombre }}</td>
                            
                            
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $transportista->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                      </svg>
                                </button>
                                <div class="modal fade" id="editModal{{ $transportista->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $transportista->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title" id="editModalLabel{{ $transportista->id }}">Editar Conductor</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Formulario para editar la guía de remisión -->
                                                <form id="editForm{{ $transportista->id }}" action="{{ route('transportista.update', $transportista->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Campos para editar -->
                                                    <div class="form-group row">
                                                        <div class="col-md-6 ">
                                                            <label for="unidad_tecnica">Unidad Tecnica:</label>
                                                            <input type="text" class="form-control" id="unidad_tecnica" name="unidad_tecnica" value="{{ $transportista->unidad_tecnica }}" required>
    
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="campo">Campo: </label>
                                                            <input type="text" class="form-control" id="campo" name="campo" value="{{ $transportista->campo    }}" required>
    
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6 ">
                                                            <label for="RUC">RUC:</label>
                                                            <input type="text" class="form-control" id="RUC" name="RUC" value="{{ $transportista->RUC }}" required>
    
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="razon_social">Razon Social: </label>
                                                            <input type="text" class="form-control" id="razon_social" name="razon_social" value="{{ $transportista->razon_social }}" required>
                                                            
    
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6 ">
                                                            <label for="codigo">CODIGO:</label>
                                                            <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $transportista->codigo }}" required>
    
                                                        </div>
                                                        <div class="col-md-6 ">
                                                            <label for="nombre">Nombre:</label>
                                                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $transportista->nombre }}" required>
    
                                                        </div>
                                                       
                                                    </div>
                                                   
                                               
                                                    <!-- Agrega aquí más campos para editar -->
                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('pago.destroy', $transportista->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" stroke-width="0" fill="currentColor" />
                                            <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor" />
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
