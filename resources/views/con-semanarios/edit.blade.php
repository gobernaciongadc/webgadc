@extends('layouts.app')

@section('template_title')
{{ __('Update') }} Con Semanario
@endsection

@section('content')
<section class="content container-fluid">
    <div class="">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">{{ __('Modificar') }} Semanario Digital</span>
                    <div class="float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('con-semanarios.index') }}"> {{ __('Regresar') }}</a>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <form method="POST" action="{{ route('con-semanarios.update', $conSemanario->id) }}" role="form" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        @csrf
                        <!-- Campo oculto para el ID -->
                        <input type="hidden" name="id" value="{{ $conSemanario->id }}">
                        @include('con-semanarios.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection