<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gobernación de Cochabamba</title>
</head>

<body>
    @if($noticias->isEmpty())
    <p>No hay noticias disponibles.</p>
    @else
    @foreach ($noticias as $noticia)
    <h1 style="text-transform: uppercase;">{{ $noticia->antetitulo }}</h1>
    <p>{{ $noticia->categorias }}</p>
    @endforeach
    @endif
</body>

</html>