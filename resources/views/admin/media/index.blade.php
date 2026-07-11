@extends('admin.layouts.app')

@section('title', 'Media Library')

@push('styles')
<style>
    .media-dropzone {
        border: 2px dashed #4e73df;
        border-radius: 12px;
        padding: 3rem 1rem;
        text-align: center;
        background: #f8f9fc;
        cursor: pointer;
        transition: all 0.3s;
    }
    .media-dropzone:hover, .media-dropzone.dragover {
        background: #eaecf4;
        border-color: #2e59d9;
    }
    .media-card {
        border: 1px solid #e3e6f0;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        transition: all 0.2s;
    }
    .media-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .media-img-wrapper {
        height: 150px;
        width: 100%;
        background: #eaecf4;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .media-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .media-actions {
        position: absolute;
        top: 10px;
        right: 10px;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .media-card:hover .media-actions {
        opacity: 1;
    }
    .media-details {
        padding: 10px;
        font-size: 0.8rem;
    }
    .media-filename {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: bold;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title m-0"><i class="fas fa-photo-video text-primary me-2"></i> Media Library</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                        @csrf
                        <div class="media-dropzone" id="dropzone">
                            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                            <h5>Drag & Drop Images Here</h5>
                            <p class="text-muted">or click to browse (Max 5MB. JPG, PNG, WEBP, GIF)</p>
                            <input type="file" name="file" id="file-input" class="d-none" accept="image/*" multiple>
                        </div>
                        @error('file')
                            <div class="text-danger mt-2 text-center">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($media as $item)
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-4">
                <div class="media-card bg-white">
                    <div class="media-img-wrapper">
                        <img src="{{ $item->url }}" alt="{{ $item->file_name }}" loading="lazy">
                    </div>
                    <div class="media-actions">
                        <button type="button" class="btn btn-sm btn-primary copy-url-btn" data-url="{{ $item->url }}" title="Copy URL">
                            <i class="fas fa-copy"></i>
                        </button>
                        <form action="{{ route('admin.media.destroy', $item) }}" method="POST" class="d-inline delete-media-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    <div class="media-details">
                        <div class="media-filename" title="{{ $item->file_name }}">{{ $item->file_name }}</div>
                        @if($item->alt_text)
                            <div class="text-muted small mt-1 text-truncate" title="{{ $item->alt_text }}">
                                <i class="fas fa-robot text-primary me-1"></i>{{ $item->alt_text }}
                            </div>
                        @endif
                        <div class="text-muted mt-1 d-flex justify-content-between" style="font-size: 0.75rem;">
                            <span>{{ number_format($item->size / 1024, 1) }} KB</span>
                            <span>{{ strtoupper(explode('/', $item->mime_type)[1] ?? 'IMG') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-images fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No media found</h4>
                <p>Upload some images to see them here.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $media->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script nonce="{{ $cspNonce ?? '' }}">
    // Drag & Drop visual effects
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('file-input');
    const uploadForm = document.getElementById('upload-form');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropzone.classList.add('dragover');
    }

    function unhighlight(e) {
        dropzone.classList.remove('dragover');
    }

    dropzone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        handleFiles(dt.files);
    }

    async function handleFiles(files) {
        if (!files || files.length === 0) return;
        
        // Show loading state
        const originalContent = dropzone.innerHTML;
        dropzone.innerHTML = `<i class="fas fa-spinner fa-spin fa-3x text-primary mb-3"></i><h5>Uploading ${files.length} file(s)...</h5><p class="text-muted">Please wait...</p>`;
        dropzone.style.pointerEvents = 'none';

        let successCount = 0;
        
        for (let i = 0; i < files.length; i++) {
            const formData = new FormData();
            formData.append('file', files[i]);
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            
            try {
                const response = await fetch('{{ route('admin.media.store') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                
                if (response.ok) {
                    successCount++;
                }
            } catch (error) {
                console.error("Upload failed for file " + files[i].name, error);
            }
            
            // Update progress text
            if(dropzone.querySelector('h5')) {
                dropzone.querySelector('h5').innerText = `Uploading ${files.length} file(s)... (${successCount}/${files.length} done)`;
            }
        }
        
        // Reload page to show new files
        window.location.reload();
    }

    // Add event listeners that were previously inline
    dropzone.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        handleFiles(this.files);
    });

    document.querySelectorAll('.copy-url-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            copyToClipboard(this.dataset.url);
        });
    });

    document.querySelectorAll('.delete-media-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to permanently delete this image?')) {
                e.preventDefault();
            }
        });
    });

    // Copy to clipboard
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('URL copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }
</script>
@endpush
