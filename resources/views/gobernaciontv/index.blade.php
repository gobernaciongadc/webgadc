@extends('layouts.app')

@section('template_title')
Con Semanarios
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Gestión Gobernación TV') }}
                        </span>
                        <a href="{{ route('categoriatv.index') }}" class="btn btn-sm btn-primary">Gestión categoria TV</a>
                        <div class="float-right">
                            <a href="{{ route('gobernaciontv.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                {{ __('Crear nuevo programa') }}
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
                        <table id="gobernaciontv" class="table table-striped table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Programa</th>
                                    <th>Categoria</th>
                                    <th>Plataforma</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transmisiones as $gobernaciontv) <!-- Cambiado a gobernaciontv -->
                                <tr>
                                    <td>{{ $gobernaciontv->programa }}</td> <!-- Cambiado a gobernaciontv -->
                                    <td>{{ $gobernaciontv->categoriaTv->nombre ?? 'Sin categoría' }}</td> <!-- Mostrando el nombre de la categoría -->
                                    <td>{{ ucfirst($gobernaciontv->plataforma) }}</td> <!-- Cambiado a gobernaciontv -->
                                    <td>{{ ucfirst($gobernaciontv->estado) }}</td> <!-- Cambiado a gobernaciontv -->
                                    <td>
                                        <a href="{{ route('gobernaciontv.edit', $gobernaciontv) }}" class="btn btn-sm btn-primary">Editar</a>
                                        <!-- Botón para eliminar -->
                                        <form action="{{ route('gobernaciontv.destroy', $gobernaciontv) }}" method="POST" style="display: inline;"> <!-- Cambiado a gobernaciontv -->
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta transmisión?');">Eliminar</button>
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