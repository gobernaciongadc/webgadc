<form action="{{ isset($gobernaciontv) ? route('gestionjakutv.update', $gobernaciontv->id) : route('gestionjakutv.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($gobernaciontv))
    @method('PUT')
    @endif

    <div class="form-group">
        <label>Nombre archivo:</label>
        <input type="text" name="nombre_archivo" class="form-control" value="{{ old('programa', $gobernaciontv->nombre ?? '') }}" required>
    </div>

    <!-- Campo para cargar archivo (PDF, Excel, MP4, Word) -->
    <div class="form-group mt-3">
        <label>Archivo:</label>
        <input type="file" name="archivo_tarjeta" class="form-control" id="archivo1" accept=".pdf,.xlsx,.mp4,.doc,.docx">
        <span class="text-danger">El archivo debe ser PDF o MP4 y no debe exceder los 2 GB.</span>
    </div>

    <!-- Campo para cargar imagen -->
    <div class="form-group mt-3">
        <label>Portada</label>
        <input type="file" name="imagen_portada" class="form-control" id="imagenPortada10" accept="image/*">
        <span class="text-danger">Las imagenes deben tener un maximo de 1 MB</span>
    </div>

    <!-- Previsualización de la imagen -->
    <div class="form-group">
        <img class="" id="preview" src="{{ isset($gobernaciontv) ? asset('storage/uploads/' . $gobernaciontv->imagen_portada) : '' }}" alt="Previsualización" style="width: 300px;display: {{ isset($gobernaciontv) ? 'block' : 'none' }};">
    </div>

    <script>
        document.getElementById('imagenPortada10').addEventListener('change', function(event) {
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




    <div class=" form-group mt-3">
        <label>Estado</label>
        <select name="estado" class="form-control" required>
            <option value="live" {{ (old('estado', $gobernaciontv->estado ?? '') == 'live') ? 'selected' : '' }}>Activo</option>
            <option value="off" {{ (old('estado', $gobernaciontv->estado ?? '') == 'off') ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <div class="form-group mt-2">
        <label>Seleccionar categoría</label>
        <select name="categoriatv_id" class="form-control" required>
            <option value="" disabled selected>-- Seleccione --</option>
            @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}" {{ (old('categoriatv_id', $gobernaciontv->categoriatv_id ?? '') == $categoria->id) ? 'selected' : '' }}>
                {{ $categoria->nombre }}
            </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">{{ isset($gobernaciontv) ? __('Actualizar') : __('Crear') }}</button>
</form>