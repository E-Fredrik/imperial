document.addEventListener('DOMContentLoaded', function () {
    // preview for per-image replace inputs (replace-<id>)
    document.querySelectorAll('input[id^="replace-"]').forEach(function (input) {
        input.addEventListener('change', function () {
            const id = this.id.replace('replace-', '');
            const img = document.getElementById('thumb-' + id);
            if (!img) return;

            const file = this.files && this.files[0];
            if (!file) return;

            const url = URL.createObjectURL(file);
            // show preview immediately
            img.src = url;

            // revoke URL after image loads
            img.onload = function () {
                URL.revokeObjectURL(url);
            };

            // status text if present
            const status = document.getElementById('status-' + id);
            if (status) status.textContent = 'Preview (unsaved)';
        });
    });

    // preview newly added images (images[] multiple)
    const newImagesInput = document.getElementById('images');
    const previewContainer = document.getElementById('new-images-preview');
    if (newImagesInput && previewContainer) {
        newImagesInput.addEventListener('change', function () {
            previewContainer.innerHTML = ''; // clear previous previews
            Array.from(this.files || []).forEach(function (file, idx) {
                if (!file.type.startsWith('image/')) return;
                const url = URL.createObjectURL(file);
                const img = document.createElement('img');
                img.src = url;
                img.className = 'w-32 h-24 object-cover rounded border';
                img.alt = 'New image preview ' + (idx + 1);
                img.onload = function () { URL.revokeObjectURL(url); };
                const wrapper = document.createElement('div');
                wrapper.className = 'mr-2 mb-2';
                wrapper.appendChild(img);
                previewContainer.appendChild(wrapper);
            });
        });
    }
});