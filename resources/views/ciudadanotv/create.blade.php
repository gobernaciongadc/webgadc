@extends('layouts.app')

@section('template_title')
{{ __('Create') }} Con Ciudadano
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <span id="card_title">
                        {{ __('Crear Link de Interes Ciudadano') }}
                    </span>
                    <div class="float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('ciudadanotv.index') }}"> {{ __('Regresar') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    @include('ciudadanotv.form') <!-- Incluir el formulario -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection