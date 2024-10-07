<form action="{{ isset($gobernaciontv) ? route('gobernaciontv.update', $gobernaciontv->id) : route('gobernaciontv.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($gobernaciontv))
    @method('PUT')
    @endif

    <div class="form-group">
        <label>Programa</label>
        <input type="text" name="programa" class="form-control" value="{{ old('programa', $gobernaciontv->programa ?? '') }}" required>
    </div>

    <!-- Campo para cargar imagen -->
    <div class="form-group">
        <label>Imagen portada</label>
        <input type="file" name="imagen_portada" class="form-control" id="imagenInput2" accept="image/*">
        <span class="text-danger">Las imagenes deben tener un maximo de 1 MB</span>
    </div>

    <!-- Previsualización de la imagen -->
    <div class="form-group mt-3">
        <img id="preview" src="{{ isset($gobernaciontv) ? asset('storage/uploads/' . $gobernaciontv->imagen) : '' }}" alt="Previsualización" style="max-width: 300px; display: {{ isset($gobernaciontv) ? 'block' : 'none' }};">
    </div>

    <script>
        document.getElementById('imagenInput2').addEventListener('change', function(event) {
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
        <label>URL YouTube</label>
        <input type="url" name="url_youtube" class="form-control" value="{{ old('url_youtube', $gobernaciontv->url_youtube ?? '') }}">
    </div>

    <div class="form-group">
        <label>URL Facebook</label>
        <input type="url" name="url_facebook" class="form-control" value="{{ old('url_facebook', $gobernaciontv->url_facebook ?? '') }}">
    </div>

    <div class="form-group">
        <label>Plataforma</label>
        <select name="plataforma" class="form-control" required>
            <option value="youtube" {{ (old('plataforma', $gobernaciontv->plataforma ?? '') == 'youtube') ? 'selected' : '' }}>YouTube</option>
            <option value="facebook" {{ (old('plataforma', $gobernaciontv->plataforma ?? '') == 'facebook') ? 'selected' : '' }}>Facebook</option>
        </select>
    </div>

    <div class="form-group">
        <label>Estado</label>
        <select name="estado" class="form-control" required>
            <option value="live" {{ (old('estado', $gobernaciontv->estado ?? '') == 'live') ? 'selected' : '' }}>Activo</option>
            <option value="off" {{ (old('estado', $gobernaciontv->estado ?? '') == 'off') ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <div class="form-group mt-2">
        <label>Selecionar categoria</label>
        <select name="categoriatv_id" class="form-control" required>
            <!-- Asumiendo que tienes un modelo Categoriatv y has pasado las categorías a la vista -->
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