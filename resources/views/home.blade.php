@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container p-3 my-3 bg-primary text-white">
        <h1 class="text-center">Gobierno Autónomo Departamental de Cochabamba</h1>
        <p class="text-center">Sistema de Administración del Portal Web del G.A.D.C.</p>
        <h2 class="text-center">Usted Pertenece A:</h2>
        <h2 class="text-center">"{{ Auth::user()->unidad->nombre}}"</h2>
    </div>
</div>
@endsection
