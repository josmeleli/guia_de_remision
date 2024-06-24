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
            <h3 class="card-title">Lista de Campos</h3>
        </div>

        <div class="card-body p-2">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Acopiadora</th>
                        <th>Ubigeo</th>
                        <th>Zona</th>
                        <th>Ingenio</th>
                        <th>Carga ID</th>
                        <th>Agricultor ID</th>
                        <th>Acciones</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($campos as $campo)
                        <tr>
                            <td>{{ $campo->id }}</td>
                            <td>{{ $campo->acopiadora }}</td>
                            <td>{{ $campo->ubigeo }}</td>
                            <td>{{ $campo->zona }}</td>
                            <td>{{ $campo->ingenio }}</td>
                            <td>{{ $campo->carga_id }}</td>
                            <td>{{ $campo->agricultor_id }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $campo->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                      </svg>
                                </button>
                                <div class="modal fade" id="editModal{{ $campo->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $campo->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title" id="editModalLabel{{ $campo->id }}">Editar Pagos</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Formulario para editar la guía de remisión -->
                                                <form id="editForm{{ $campo->id }}" action="{{ route('pago.update', $campo->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Campos para editar -->
                                                    <div class="form-group row">
                                                        <div class="col-md-6 ">
                                                            <label for="acopiadora">Acopiadora:</label>
                                                            <input type="text" class="form-control" id="acopiadora" name="acopiadora" value="{{ $campo->acopiadora }}" required>
    
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="ubigeo">Ubigeo: </label>
                                                            <input type="text" class="form-control" id="ubigeo" name="ubigeo" value="{{ $campo->ubigeo }}" required>
    
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6 ">
                                                            <label for="zona">Zona:</label>
                                                            <input type="text" class="form-control" id="zona" name="zona" value="{{ $campo->zona }}" required>
    
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="ingenio">Ingenio: </label>
                                                            <input type="text" class="form-control" id="ingenio" name="ingenio" value="{{ $campo->ingenio }}" required>
    
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6 ">
                                                            <label for="carga_id">ID Carga:</label>
                                                            <select class="form-control" id="carga_id" name="carga_id" required>
                                                                <option value="" selected disabled >{{$campo->carga_id}} </option>
                                                                @foreach($cargas as $carga)
                                                                    <option value="{{ $carga->id }}" {{ $carga->carga_id == $carga->id ? 'selected' : '' }}>{{ $carga->total_carga_neta }}</option>
                                                                @endforeach
                                                            </select>
    
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="agricultor_id">ID Agricultor: </label>
                                                        
                                                            <select class="form-control" id="campo_id" name="campo_id" required>
                                                                <option value="" selected disabled >{{$campo->agricultor_id}} </option>
                                                                @foreach($agricultores as $agricultor)
                                                                    <option value="{{ $agricultor->id }}" {{ $agricultor->agricultor_id == $agricultor->id ? 'selected' : '' }}>{{ $agricultor->nombres }}</option>
                                                                @endforeach
                                                            </select>
    
                                                        </div>
                                                       
                                                    </div>
                                                    
                                                   
                                                    
                                                       
                                                
                                                    <!-- Agrega aquí más campos para editar -->
                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('pago.destroy', $campo->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor" />
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
