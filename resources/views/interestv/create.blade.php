@extends('layouts.app')

@section('template_title')
{{ __('Create') }} Con de tu interés
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <span id="card_title">
                        {{ __('Crear de tu interés') }}
                    </span>
                    <div class="float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('interestv.index') }}"> {{ __('Regresar') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    @include('interestv.form') <!-- Incluir el formulario -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection