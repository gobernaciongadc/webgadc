@extends('layouts.app')

@section('template_title')
De tu interes
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Gestión de tu interes') }}
                        </span>
                        <div class="float-right">
                            <a href="{{ route('interestv.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                {{ __('Crear Interes Ciudadano') }}
                            </a>
                        </div>
                    </div>
                </div>

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success">
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                <div class="card-body bg-white">
                    <div class="table-responsive">
                        <table id="modaltv" class="table table-striped table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transmisiones as $gobernaciontv) <!-- Cambiado a gobernaciontv -->
                                <tr>
                                    <td>{{ $gobernaciontv->descripcion }}</td> <!-- Cambiado a gobernaciontv -->
                                    <td>{{ ucfirst($gobernaciontv->estado) }}</td> <!-- Cambiado a gobernaciontv -->
                                    <td>
                                        <a href="{{ route('interestv.edit', $gobernaciontv) }}" class="btn btn-sm btn-primary">Editar</a>
                                        <!-- Botón para eliminar -->
                                        <form action="{{ route('interestv.destroy', $gobernaciontv) }}" method="POST" style="display: inline;"> <!-- Cambiado a gobernaciontv -->
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas dar de baja la radio?');">Cambiar estado</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection