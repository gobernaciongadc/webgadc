@extends('layouts.app')

@section('template_title')
{{ __('Create') }} Con Radio
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <span id="card_title">
                        {{ __('Crear Radio') }}
                    </span>
                    <div class="float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('radiotv.index') }}"> {{ __('Regresar') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    @include('radiotv.form') <!-- Incluir el formulario -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection