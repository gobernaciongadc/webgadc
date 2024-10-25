@extends('layouts.app')

@section('template_title')
{{ __('Update') }} Con de tu interes
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header">
                        <span class="card-title">{{ __('Modificar') }} de tu interés</span>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('interestv.index') }}"> {{ __('Regresar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('interestv.form', ['gobernaciontv' => $gobernaciontv]) <!-- Incluir el formulario -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection