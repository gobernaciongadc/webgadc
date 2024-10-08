@extends('layouts.app')

@section('template_title')
{{ __('Update') }} Con Ciudadano
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header">
                        <span class="card-title">{{ __('Modificar') }} Link</span>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('ciudadanotv.index') }}"> {{ __('Regresar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('ciudadanotv.form', ['gobernaciontv' => $gobernaciontv]) <!-- Incluir el formulario -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection