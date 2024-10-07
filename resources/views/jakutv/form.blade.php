<form action="{{ isset($gobernaciontv) ? route('jakutv.update', $gobernaciontv->id) : route('jakutv.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($gobernaciontv))
    @method('PUT')
    @endif

    <div class="form-group">
        <label>Nombre tarjeta</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $gobernaciontv->nombre ?? '') }}" required>
    </div>



    <!-- Campo para cargar imagen -->
    <div class="form-group mt-3">
        <label>Portada tarjeta</label>
        <input type="file" name="imagen_tarjeta" class="form-control" id="imagenInput3" accept="image/*">
        <span class="text-danger">Las imagenes deben tener un maximo de 1 MB</span>
    </div>

    <!-- Previsualización de la imagen -->
    <div class="form-group">
        <img id="preview" src="{{ isset($gobernaciontv) ? asset('storage/uploads/' . $gobernaciontv->imagen) : '' }}" alt="Previsualización" style="max-width: 300px; display: {{ isset($gobernaciontv) ? 'block' : 'none' }};">
    </div>

    <script>
        document.getElementById('imagenInput3').addEventListener('change', function(event) {
            const [file] = event.target.files;
            const preview = document.getElementById('preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>



    <div class="form-group">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control" required>{{ old('descripcion', $gobernaciontv->descripcion ?? '') }}</textarea>
    </div>


    <div class="form-group">
        <label>Estado</label>
        <select name="estado" class="form-control" required>
            <option value="live" {{ (old('estado', $gobernaciontv->estado ?? '') == 'live') ? 'selected' : '' }}>Activo</option>
            <option value="off" {{ (old('estado', $gobernaciontv->estado ?? '') == 'off') ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>


    <button type="submit" class="btn btn-success">{{ isset($gobernaciontv) ? __('Actualizar') : __('Crear') }}</button>
</form>