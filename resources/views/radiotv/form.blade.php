<form action="{{ isset($gobernaciontv) ? route('radiotv.update', $gobernaciontv->id) : route('radiotv.store') }}" method="POST">
    @csrf
    @if(isset($gobernaciontv))
    @method('PUT')
    @endif

    <div class="form-group">
        <label>Url Radio</label>
        <input type="text" name="url_radio" class="form-control" value="{{ old('url_radio', $gobernaciontv->url_radio ?? '') }}" required>
    </div>


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