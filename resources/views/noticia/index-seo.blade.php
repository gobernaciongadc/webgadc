<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Noticias</title>
</head>

<body>
    <h1>Listado de Noticias</h1>

    @if ($noticias->isEmpty())
    <p>No hay noticias disponibles.</p>
    @else
    <ul>
        @foreach ($noticias as $noticia)
        <li>
            <a href="{{ route('detalle-noticias', ['titulo' => urlencode($noticia->titulo)]) }}">
                Leer más: {{ $noticia->titulo }}
            </a>
        </li>
        @endforeach
    </ul>
    @endif

</body>

</html>