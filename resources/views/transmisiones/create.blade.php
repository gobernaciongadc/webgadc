@extends('layouts.app')

@section('template_title')
{{ __('Create') }} Con Semanario
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <span id="card_title">
                        {{ __('Crear Nueva Transmisión') }}
                    </span>
                </div>

                <div class="card-body">
                    @include('transmisiones.form') <!-- Incluir el formulario -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection