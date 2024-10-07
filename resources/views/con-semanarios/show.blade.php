@extends('layouts.app')

@section('template_title')
{{ $conSemanario->name ?? __('Show') . " " . __('Con Semanario') }}
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="float-left">
                        <span class="card-title">{{ __('Show') }} Con Semanario</span>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('con-semanarios.index') }}"> {{ __('Regresar') }}</a>
                    </div>
                </div>

                <div class="card-body bg-white">

                    <div class="form-group mb-2 mb20">
                        <strong>Edicion:</strong>
                        {{ $conSemanario->edicion }}
                    </div>
                    <div class="form-group mb-2 mb20">
                        <strong>Fecha Publicacion:</strong>
                        {{ $conSemanario->fecha_publicacion }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection