document.addEventListener('DOMContentLoaded', () => {

    const modal        = document.getElementById('deleteModal');
    const modalCancel  = document.getElementById('modalCancel');
    const modalConfirm = document.getElementById('modalConfirm');
    let   pendingId    = null;

    document.addEventListener('click', e => {
        const btn = e.target.closest('[data-delete-id]');
        if (!btn) return;
        pendingId = btn.dataset.deleteId;
        const nombreEl = document.getElementById('modalProductName');
        if (nombreEl) nombreEl.textContent = btn.dataset.deleteName || 'este producto';
        if (modal) modal.classList.add('is-active');
    });

    if (modalCancel) modalCancel.addEventListener('click', closeModal);
    modal?.querySelector('.modal-background')?.addEventListener('click', closeModal);

    if (modalConfirm) {
        modalConfirm.addEventListener('click', () => {
            if (!pendingId) return;
            modalConfirm.classList.add('is-loading');
            const body = new FormData();
            body.append('id', pendingId);

            fetch('Backend/ajax/admin_eliminar_producto.php', { method: 'POST', body })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.mensaje, 'success');
                        const row = document.querySelector(`tr[data-product-id="${pendingId}"]`);
                        if (row) {
                            row.style.transition = 'opacity .3s';
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 300);
                        }
                    } else {
                        showToast(data.mensaje, 'error');
                    }
                })
                .catch(() => showToast('Error al eliminar.', 'error'))
                .finally(() => { modalConfirm.classList.remove('is-loading'); closeModal(); });
        });
    }

    function closeModal() {
        if (modal) modal.classList.remove('is-active');
        pendingId = null;
    }

    const uploadZone     = document.getElementById('uploadZone');
    const fileInput      = document.getElementById('fileInput');
    const imagenInput    = document.getElementById('imagenInput');
    const imgPreview     = document.getElementById('imgPreview');
    const imgPreviewWrap = document.getElementById('imgPreviewWrap');
    const imgFilename    = document.getElementById('imgFilename');
    const uploadProgress = document.getElementById('uploadProgress');
    const uploadMsg      = document.getElementById('uploadMsg');

    if (fileInput) {
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) uploadFile(fileInput.files[0]);
        });

        uploadZone?.addEventListener('dragover', e => {
            e.preventDefault();
            uploadZone.classList.add('is-dragging');
        });
        uploadZone?.addEventListener('dragleave', () => uploadZone.classList.remove('is-dragging'));
        uploadZone?.addEventListener('drop', e => {
            e.preventDefault();
            uploadZone.classList.remove('is-dragging');
            if (e.dataTransfer.files[0]) uploadFile(e.dataTransfer.files[0]);
        });

        if (imagenInput?.value) uploadZone.style.display = 'none';
    }

    function uploadFile(file) {
        const allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!allowed.includes(file.type)) {
            setUploadMsg('Solo se permiten imágenes JPG, PNG, WEBP o GIF.', 'danger'); return;
        }
        if (file.size > 3 * 1024 * 1024) {
            setUploadMsg('El archivo supera el límite de 3MB.', 'danger'); return;
        }

        const formData = new FormData();
        formData.append('imagen', file);

        uploadProgress.style.display = 'block';
        uploadProgress.value = 0;
        setUploadMsg('Subiendo imagen...', 'info');

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'Backend/ajax/upload_imagen.php');

        xhr.upload.addEventListener('progress', e => {
            if (e.lengthComputable) uploadProgress.value = Math.round((e.loaded / e.total) * 100);
        });

        xhr.addEventListener('load', () => {
            uploadProgress.style.display = 'none';
            try {
                const data = JSON.parse(xhr.responseText);
                if (data.success) {
                    imagenInput.value = data.filename;
                    imgPreview.src = data.url;
                    if (imgFilename)    imgFilename.textContent = data.filename;
                    if (imgPreviewWrap) imgPreviewWrap.style.display = 'flex';
                    if (uploadZone)     uploadZone.style.display = 'none';
                    setUploadMsg('✅ Imagen subida correctamente.', 'success');
                } else {
                    setUploadMsg('❌ ' + data.mensaje, 'danger');
                }
            } catch { setUploadMsg('❌ Error al procesar la respuesta.', 'danger'); }
        });

        xhr.addEventListener('error', () => {
            uploadProgress.style.display = 'none';
            setUploadMsg('❌ Error de conexión.', 'danger');
        });

        xhr.send(formData);
    }

    function setUploadMsg(text, type) {
        if (!uploadMsg) return;
        uploadMsg.textContent = text;
        uploadMsg.className = `help is-${type} mt-1`;
    }

    const params = new URLSearchParams(window.location.search);
    if (params.get('exito') === '1') {
        showToast('Producto guardado correctamente.', 'success');
        history.replaceState({}, '', window.location.pathname + '?page=admin_productos');
    }
});

function clearImage() {
    document.getElementById('imagenInput').value  = '';
    document.getElementById('imgPreviewWrap').style.display = 'none';
    document.getElementById('uploadZone').style.display     = '';
    document.getElementById('uploadMsg').textContent        = '';
    document.getElementById('fileInput').value              = '';
}