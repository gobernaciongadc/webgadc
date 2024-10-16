<form action="{{ isset($gobernaciontv) ? route('ciudadanotv.update', $gobernaciontv->id) : route('ciudadanotv.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($gobernaciontv))
    @method('PUT')
    @endif

    <div class="form-group">
        <label>Url de Enlace</label>
        <input type="text" name="url_documento" class="form-control" value="{{ old('url_documento', $gobernaciontv->url_documento ?? '') }}" required>
    </div>

    <!-- Campo para cargar imagen -->
    <div class="form-group mt-3">
        <label>Imagen portada</label>
        <input type="file" name="imagen_ciudadano" class="form-control" id="imagenCiudadano" accept="image/*">
        <span class="text-danger">Las imagenes deben tener un maximo de 1 MB</span>
    </div>


    <!-- Previsualización de la imagen -->
    <div class="form-group">
        <img class="" id="preview" src="{{ isset($gobernaciontv) ? asset('storage/uploads/' . $gobernaciontv->imagen) : '' }}" alt="Previsualización Imagen" style="width: 300px;display: {{ isset($gobernaciontv) ? 'block' : 'none' }};">
    </div>

    <script>
        document.getElementById('imagenCiudadano').addEventListener('change', function(event) {

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