<!-- Media Picker Modal -->
<div class="modal fade" id="mediaPickerModal" tabindex="-1" aria-labelledby="mediaPickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="mediaPickerModalLabel"><i class="fas fa-photo-video text-primary me-2"></i> Select Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="container-fluid py-3">
                    <!-- Upload Tab/Area -->
                    <div class="row mb-4 px-3">
                        <div class="col-12">
                            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="modal-upload-form">
                                @csrf
                                <div class="media-dropzone py-2" id="modal-dropzone" style="border: 2px dashed #4e73df; border-radius: 8px; text-align: center; cursor: pointer; background: #f8f9fc;" onclick="document.getElementById('modal-file-input').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                                    <p class="mb-0">Click or Drag to upload new media</p>
                                    <input type="file" name="file" id="modal-file-input" class="d-none" accept="image/*">
                                </div>
                                <div id="modal-upload-progress" class="progress mt-2 d-none" style="height: 10px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Gallery Grid -->
                    <div class="row px-3" id="media-gallery-grid">
                        <!-- Populated via AJAX -->
                        <div class="col-12 text-center py-5" id="media-loading">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn-select-media" disabled>Select Image</button>
            </div>
        </div>
    </div>
</div>

<style>
    .media-picker-item {
        border: 2px solid transparent;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 1rem;
        position: relative;
    }
    .media-picker-item:hover {
        transform: scale(1.02);
    }
    .media-picker-item.selected {
        border-color: #4e73df;
        box-shadow: 0 0 10px rgba(78, 115, 223, 0.5);
    }
    .media-picker-item.selected::after {
        content: '\f058';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        top: 5px;
        right: 5px;
        color: #4e73df;
        background: white;
        border-radius: 50%;
        font-size: 1.5rem;
        line-height: 1;
    }
    .media-picker-img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        background: #eaecf4;
    }
</style>

<script>
    let currentInputTarget = null;
    let currentPreviewTarget = null;
    let selectedMediaUrl = null;
    let mediaLoaded = false;

    // Open Modal and set targets
    function openMediaPicker(inputId, previewId) {
        currentInputTarget = document.getElementById(inputId);
        currentPreviewTarget = document.getElementById(previewId);
        selectedMediaUrl = null;
        document.getElementById('btn-select-media').disabled = true;
        
        const modal = new bootstrap.Modal(document.getElementById('mediaPickerModal'));
        modal.show();

        if (!mediaLoaded) {
            loadMedia();
        }
    }

    // Fetch media from server
    function loadMedia(page = 1) {
        const grid = document.getElementById('media-gallery-grid');
        if (page === 1) grid.innerHTML = '<div class="col-12 text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>';

        fetch(`{{ route('admin.media.index') }}?page=${page}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (page === 1) grid.innerHTML = '';
            
            if (data.data.length === 0 && page === 1) {
                grid.innerHTML = '<div class="col-12 text-center text-muted py-4">No media uploaded yet.</div>';
                return;
            }

            data.data.forEach(item => {
                grid.innerHTML += `
                    <div class="col-4 col-md-3 col-lg-2">
                        <div class="media-picker-item" onclick="selectMedia(this, '${item.url}')">
                            <img src="${item.url}" class="media-picker-img" alt="${item.file_name}" loading="lazy">
                        </div>
                    </div>
                `;
            });
            
            mediaLoaded = true;
        })
        .catch(err => {
            grid.innerHTML = '<div class="col-12 text-danger text-center py-4">Failed to load media.</div>';
            console.error(err);
        });
    }

    // Select media item in grid
    function selectMedia(element, url) {
        // Deselect all
        document.querySelectorAll('.media-picker-item').forEach(el => el.classList.remove('selected'));
        // Select current
        element.classList.add('selected');
        selectedMediaUrl = url;
        document.getElementById('btn-select-media').disabled = false;
    }

    // Confirm selection
    document.getElementById('btn-select-media').addEventListener('click', function() {
        if (selectedMediaUrl && currentInputTarget) {
            // Depending on the field type, we might want to store the URL or a path
            // For simplicity, we store the full URL, or just the relative path.
            // Let's store the relative path by stripping the app URL if it exists
            
            let storedPath = selectedMediaUrl;
            const appUrl = "{{ config('app.url') }}/storage/";
            if (selectedMediaUrl.startsWith(appUrl)) {
                 storedPath = selectedMediaUrl.replace(appUrl, '');
            } else {
                 // For absolute urls, we can just use the url directly or format it based on the requirement
                 // Assuming local public disk for now which stores like "media/2026/05/uuid.jpg"
                 const urlObj = new URL(selectedMediaUrl);
                 storedPath = urlObj.pathname.replace('/storage/', '');
            }

            // Sometimes the input is just an input text box we show to user. 
            // In our system, usually files are handled via Uploads. 
            // If we refactor an existing entity (like Blog image), we might need to change the DB to save a string instead of doing a file upload in the controller.
            
            currentInputTarget.value = storedPath;
            
            if (currentPreviewTarget) {
                currentPreviewTarget.src = selectedMediaUrl;
                currentPreviewTarget.classList.remove('d-none');
            }

            bootstrap.Modal.getInstance(document.getElementById('mediaPickerModal')).hide();
        }
    });

    // AJAX Upload inside modal
    document.getElementById('modal-file-input').addEventListener('change', function() {
        if (!this.files.length) return;
        
        const form = document.getElementById('modal-upload-form');
        const formData = new FormData(form);
        const progressBar = document.getElementById('modal-upload-progress');
        
        progressBar.classList.remove('d-none');
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw response;
            return response.json();
        })
        .then(data => {
            progressBar.classList.add('d-none');
            // Reload grid to show new image at the top
            loadMedia(1);
        })
        .catch(async (error) => {
            progressBar.classList.add('d-none');
            let msg = 'Upload failed.';
            if (error.json) {
                const errData = await error.json();
                msg = errData.message || msg;
            }
            alert(msg);
        });
    });
</script>
