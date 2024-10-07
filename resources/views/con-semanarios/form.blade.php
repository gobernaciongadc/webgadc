<div class="row padding-1 p-1">
    <div class="col-md-12">

        <!-- Campo para la edición del semanario -->
        <div class="form-group mb-2 mb20">
            <label for="edicion" class="form-label">{{ __('Edicion') }}</label>
            <input type="text" name="edicion" class="form-control @error('edicion') is-invalid @enderror" value="{{ old('edicion', isset($conSemanario) ? $conSemanario->edicion : '') }}" id="edicion" placeholder="Ingrese la edicion">
            {!! $errors->first('edicion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Campo para la fecha de publicación -->
        <div class="form-group mb-2 mb20">
            <label for="fecha_publicacion" class="form-label">{{ __('Fecha Publicacion') }}</label>
            <input type="text" name="fecha_publicacion" class="form-control @error('fecha_publicacion') is-invalid @enderror" value="{{ old('fecha_publicacion', isset($conSemanario) ? $conSemanario->fecha_publicacion : '') }}" id="fecha_publicacion" placeholder="Ingrese la fecha de publicacion">
            {!! $errors->first('fecha_publicacion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>




        <!-- Mostrar imágenes existentes con opción para eliminar -->
        @if(isset($conSemanario) && count($imagenes) > 0)

        <div class="form-group mb-2 mb20">
            <label>{{ __('Imágenes existentes') }}</label>
            <div class="row">
                @foreach($imagenes as $imagen)
                <div class="col-md-3">
                    <!-- Mostrar miniatura de la imagen existente -->
                    <img style="width: 350px;" src="{{ asset('storage/uploads/' . $imagen->imagen) }}" class="img-thumbnail img-fluid" alt="Imagen existente">

                    <!-- Checkbox para eliminar la imagen -->
                    <div class="form-check mt-2">
                        <input type="checkbox" name="eliminar_imagenes[]" value="{{ $imagen->id }}" class="form-check-input">
                        <label class="form-check-label" for="eliminar_imagenes[]">Eliminar imagen</label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Campo para subir nuevas imágenes -->
        <div class="form-group mb-2 mb20">
            <label for="imagenes" class="form-label">{{ __('Imágenes nuevas') }}</label>
            <input type="file" name="imagenes[]" class="form-control @error('imagenes') is-invalid @enderror" id="imagenes" multiple>
            {!! $errors->first('imagenes', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Vista previa de nuevas imágenes que se van a cargar -->
        <div class="form-group mb-2 mb20">
            <label>{{ __('Vista previa de las imágenes nuevas') }}</label>
            <div id="preview-imagenes" class="row"></div>
        </div>

    </div>

    <!-- Botón para guardar los cambios -->

    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Guardar semanario') }}</button>
        <div class="mt-2"><span class="text-danger font-weight-bold">*</span>
            Por favor, asegúrese de que la imagen que desea subir tenga las siguientes dimensiones:
            Ancho: 1000px
            Altura: 1325px
        </div>
    </div>

</div>
</div>