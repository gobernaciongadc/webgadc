<form action="{{ isset($gobernaciontv) ? route('categoriatv.update', $gobernaciontv->id) : route('categoriatv.store') }}" method="POST">
    @csrf
    @if(isset($gobernaciontv))
    @method('PUT')
    @endif

    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $gobernaciontv->nombre ?? '') }}" required>
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