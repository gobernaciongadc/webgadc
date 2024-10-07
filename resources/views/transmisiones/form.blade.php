<!-- resources/views/transmisiones/form.blade.php -->
<form action="{{ isset($transmision) ? route('transmisiones.update', $transmision) : route('transmisiones.store') }}" method="POST">
    @csrf
    @if(isset($transmision))
    @method('PUT')
    @endif

    <div class="form-group">
        <label>Programa</label>
        <input type="text" name="programa" class="form-control" value="{{ old('programa', $transmision->programa ?? '') }}" required>
    </div>

    <div class="form-group">
        <label>Horario</label>
        <input type="text" name="horario" class="form-control" value="{{ old('horario', $transmision->horario ?? '') }}" required>
    </div>

    <div class="form-group">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control" required>{{ old('descripcion', $transmision->descripcion ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label>URL YouTube</label>
        <input type="url" name="url_youtube" class="form-control" value="{{ old('url_youtube', $transmision->url_youtube ?? '') }}">
    </div>

    <div class="form-group">
        <label>URL Facebook</label>
        <input type="url" name="url_facebook" class="form-control" value="{{ old('url_facebook', $transmision->url_facebook ?? '') }}">
    </div>

    <div class="form-group">
        <label>Plataforma</label>
        <select name="plataforma" class="form-control" required>
            <option value="youtube" {{ (old('plataforma', $transmision->plataforma ?? '') == 'youtube') ? 'selected' : '' }}>YouTube</option>
            <option value="facebook" {{ (old('plataforma', $transmision->plataforma ?? '') == 'facebook') ? 'selected' : '' }}>Facebook</option>
        </select>
    </div>

    <div class="form-group">
        <label>Estado</label>
        <select name="estado" class="form-control" required>
            <option value="live" {{ (old('estado', $transmision->estado ?? '') == 'live') ? 'selected' : '' }}>En Vivo</option>
            <option value="off" {{ (old('estado', $transmision->estado ?? '') == 'off') ? 'selected' : '' }}>Fuera de Línea</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">{{ isset($transmision) ? 'Actualizar' : 'Guardar' }}</button>
</form>