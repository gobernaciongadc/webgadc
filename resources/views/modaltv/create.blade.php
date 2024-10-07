@extends('layouts.app')

@section('template_title')
{{ __('Create') }} Con Modal
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <span id="card_title">
                        {{ __('Crear Modal') }}
                    </span>
                    <div class="float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('modaltv.index') }}"> {{ __('Regresar') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    @include('modaltv.form') <!-- Incluir el formulario -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection