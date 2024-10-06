@extends('layouts.app')

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <!-- Breadcrumb Area Start -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Administracion</li>
            <li class="breadcrumb-item active" aria-current="page">Denuncia</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <h3 align="center">Lista de Denuncias</h3>
        <div class="col-md-12">
            <div class="col-md-12">
                <br>
                <div class="content" id="contenidoLista">
                    <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                        <thead>
                        <tr>
                            <th>N° </th>
                            <th>Denuncia</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th width="15%">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $indice = 1;
                        @endphp
                        @foreach ($lista as $key => $item)
                            <tr>
                                <td>{{$lista->firstItem() + $key}}</td>
                                <td>
                                    {{$item->denuncia}}
                                </td>
                                <td>
                                    {{$item->nombre}}
                                </td>
                                <td>
                                    {{$item->correo}}
                                </td>
                                <td>
                                    @if (verificarAcceso(98))
                                        <a href="{{ url('sisadmin/denuncia/show/'.$item->den_id) }}" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> Ver Denuncia</a>
                                    @else
                                        <a href="#" class="btn btn-warning btn-sm disabled"><i class="fa fa-eye"></i> Ver Denuncia</a>
                                    @endif                                    
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $lista->appends(['searchtype'=>$searchtype,'search'=>$search,'sort'=>$sort])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">

    </script>
@endsection
