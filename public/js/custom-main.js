$('#semanario').DataTable({
    // language: {
    //     url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'
    // }
});

$('#gobernaciontv').DataTable({
    // language: {
    //     url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'
    // }
});

$('#modaltv').DataTable({
    // language: {
    //     url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'
    // }
});


// Subir imágenes semanario digital
document.getElementById('imagenes').addEventListener('change', function (event) {
    let preview = document.getElementById('preview-imagenes');
    preview.innerHTML = ''; // Limpiar cualquier vista previa anterior

    const files = event.target.files;

    if (files) {
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    img.style.maxWidth = '150px';
                    img.style.margin = '10px';
                    preview.appendChild(img);
                };

                reader.readAsDataURL(file);
            }
        });
    }
});


