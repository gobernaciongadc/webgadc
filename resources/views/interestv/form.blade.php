<form action="{{ isset($gobernaciontv) ? route('interestv.update', $gobernaciontv->id) : route('interestv.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($gobernaciontv))
    @method('PUT')
    @endif


    <!-- Campo para cargar imagen -->
    <div class="form-group">
        <label>Imagen</label>
        <input type="file" name="imagen" class="form-control" id="imagenInputInteres" accept="image/*">
        <p class="text-danger mt-2">El tamaño maximo de la imagen es de 2MB - Tamaño recomendado 1100px x 1441px </p>
    </div>

    <!-- Previsualización de la imagen -->
    <div class="form-group">
        <img id="preview" src="{{ isset($gobernaciontv) ? asset('storage/uploads/' . $gobernaciontv->imagen) : '' }}" alt="Previsualización" style="max-width: 300px; display: {{ isset($gobernaciontv) ? 'block' : 'none' }};">
    </div>

    <script>
        document.getElementById('imagenInputInteres').addEventListener('change', function(event) {
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