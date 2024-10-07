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
                            {{ __('Gestión de transmisiones en vivo ') }}
                        </span>

                        <div class="float-right">
                            <a href="{{ route('transmisiones.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                {{ __('Crear nueva transmision') }}
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
                    <p>Transmision online creado exitosamente..</p>
                </div>
                @endif


                <div class="card-body bg-white">
                    <div class="table-responsive">
                        <table id="semanario" class="table table-striped table-hover" style="width: 100%;">

                            <thead>
                                <tr>
                                    <th>Programa</th>
                                    <th>Horario</th>
                                    <th>Plataforma</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transmisiones as $transmision)
                                <tr>
                                    <td>{{ $transmision->programa }}</td>
                                    <td>{{ $transmision->horario }}</td>
                                    <td>{{ ucfirst($transmision->plataforma) }}</td>
                                    <td>{{ ucfirst($transmision->estado) }}</td>
                                    <td>
                                        <a href="{{ route('transmisiones.edit', $transmision) }}" class="btn btn-sm btn-primary">Editar</a>

                                        <!-- Botón para eliminar -->
                                        <form action="{{ route('transmisiones.destroy', $transmision) }}" method="POST" style="display: inline;">
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