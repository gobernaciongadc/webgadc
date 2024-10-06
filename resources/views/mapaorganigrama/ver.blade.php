@extends('layouts.app')

@section('header_styles')
    <style type="text/css">
        .imagen > img
        {
            /*max-width: 100%;*/
        }
    </style>
@endsection
@section('content')
    <div class="row justify-content-center">

        <hr>
        <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-10 imagen">
                {!! $unidad->mapa_organigrama !!}
            </div>
            <div class="col-md-2"></div>
        </div>


    </div>

@endsection

@section('footer_scripts')

    <script type="text/javascript">
        $(document).ready(function(){


        });

    </script>
@endsection
