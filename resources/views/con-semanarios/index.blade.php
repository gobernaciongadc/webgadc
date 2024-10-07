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
                            {{ __('Gestión de semanarios digitales') }}
                        </span>

                        <div class="float-right">
                            <a href="{{ route('con-semanarios.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                {{ __('Crear nuevo registro') }}
                            </a>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success m-4">
                    <p>Semanario creado exitosamente..</p>
                </div>
                @endif

                <div class="card-body bg-white">
                    <div class="table-responsive">
                        <table id="semanario" class="table table-striped table-hover" style="width: 100%;">
                            <thead class="thead">
                                <tr>
                                    <th style="width: 10%;">No</th>

                                    <th style="width: 30%;">Edicion</th>
                                    <th style="width: 30%;">Fecha Publicacion</th>

                                    <th style="width: 30%;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($conSemanarios as $conSemanario)
                                <tr>
                                    <td>{{ ++$i }}</td>

                                    <td>{{ $conSemanario->edicion }}</td>
                                    <td>{{ $conSemanario->fecha_publicacion }}</td>

                                    <td>
                                        <form action="{{ route('con-semanarios.destroy', $conSemanario->id) }}" method="POST">
                                            <a class="btn btn-sm btn-primary " href="{{ route('con-semanarios.show', $conSemanario->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                            <a class="btn btn-sm btn-success" href="{{ route('con-semanarios.edit', $conSemanario->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Esta seguro de querer borrarlo?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $conSemanarios->withQueryString()->links() !!}
        </div>
    </div>
</div>
@endsection