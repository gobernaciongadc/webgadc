<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $noticia->antetitulo }}</title>

    <!-- Metadatos Generados -->
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
</head>

<body>

    <h1>{{ $noticia->titulo }}</h1>
    <img src="{{ asset('storage/uploads/' . $noticia->imagen) }}" alt="{{ $noticia->antetitulo }}">

    <script>
        // Redirigir después de 5 segundos
        setTimeout(function() {
            window.location.href = "https://gobernaciondecochabamba.bo/web/detalle-noticias/" + "{{ urlencode($noticia->titulo) }}" + "/individual";
        }, 500); // 5000 ms = 5 segundos
    </script>
</body>

</html>