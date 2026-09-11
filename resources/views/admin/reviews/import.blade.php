@extends('admin.layouts.app')

@section('title', 'Import Reviews')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Import Reviews</h3>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Reviews
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6>Validation Errors:</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('import_errors_list'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <h6>Import Errors:</h6>
                            <div style="max-height: 300px; overflow-y: auto;">
                                <ul class="mb-0">
                                    @foreach(session('import_errors_list') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-upload"></i> Upload Reviews File
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.reviews.import') }}" method="POST" enctype="multipart/form-data" id="import-form">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="import_file" class="form-label">Select File</label>
                                            <input type="file" 
                                                   class="form-control @error('import_file') is-invalid @enderror" 
                                                   id="import_file" 
                                                   name="import_file" 
                                                   accept=".xlsx,.xls,.csv"
                                                   required>
                                            @error('import_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                Supported formats: Excel (.xlsx, .xls) and CSV (.csv). Maximum file size: 10MB.
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary btn-lg" id="import-btn">
                                                <i class="fas fa-upload"></i> Import Reviews
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-info-circle"></i> Import Instructions
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <ol class="list-group list-group-numbered">
                                        <li class="list-group-item border-0 px-0">Download the template file</li>
                                        <li class="list-group-item border-0 px-0">Fill in your review data</li>
                                        <li class="list-group-item border-0 px-0">Save as Excel or CSV</li>
                                        <li class="list-group-item border-0 px-0">Upload the file using the form</li>
                                    </ol>

                                    <hr>

                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.reviews.template') }}" class="btn btn-outline-success">
                                            <i class="fas fa-download"></i> Download Template
                                        </a>
                                    </div>

                                    <div class="mt-3">
                                        <h6>Required Fields:</h6>
                                        <ul class="list-unstyled small">
                                            <li><i class="fas fa-check text-success"></i> client_name</li>
                                            <li><i class="fas fa-check text-success"></i> review_text</li>
                                        </ul>

                                        <h6>Optional Fields:</h6>
                                        <ul class="list-unstyled small">
                                            <li><i class="fas fa-circle text-muted"></i> client_position</li>
                                            <li><i class="fas fa-circle text-muted"></i> client_company</li>
                                            <li><i class="fas fa-circle text-muted"></i> rating (1-5)</li>
                                            <li><i class="fas fa-circle text-muted"></i> project_type</li>
                                            <li><i class="fas fa-circle text-muted"></i> is_featured (true/false)</li>
                                            <li><i class="fas fa-circle text-muted"></i> is_approved (true/false)</li>
                                            <li><i class="fas fa-circle text-muted"></i> sort_order</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-table"></i> Sample Data Format
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>client_name</th>
                                            <th>client_position</th>
                                            <th>client_company</th>
                                            <th>review_text</th>
                                            <th>rating</th>
                                            <th>project_type</th>
                                            <th>is_featured</th>
                                            <th>is_approved</th>
                                            <th>sort_order</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>John Doe</td>
                                            <td>CEO</td>
                                            <td>Acme Corp</td>
                                            <td>Excellent service and great results!</td>
                                            <td>5</td>
                                            <td>Web Development</td>
                                            <td>true</td>
                                            <td>true</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>Jane Smith</td>
                                            <td>Marketing Director</td>
                                            <td>Tech Solutions</td>
                                            <td>Professional team with outstanding delivery.</td>
                                            <td>5</td>
                                            <td>Digital Marketing</td>
                                            <td>false</td>
                                            <td>true</td>
                                            <td>2</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script nonce="{{ $cspNonce ?? '' }}">
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('import-form');
    const btn = document.getElementById('import-btn');
    const fileInput = document.getElementById('import_file');

    form.addEventListener('submit', function() {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Importing...';
        btn.disabled = true;
    });

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const fileSize = file.size / 1024 / 1024; // Size in MB
            if (fileSize > 10) {
                alert('File size exceeds 10MB limit. Please choose a smaller file.');
                this.value = '';
                return;
            }

            const fileName = file.name.toLowerCase();
            const validExtensions = ['.xlsx', '.xls', '.csv'];
            const isValid = validExtensions.some(ext => fileName.endsWith(ext));
            
            if (!isValid) {
                alert('Invalid file format. Please select an Excel (.xlsx, .xls) or CSV (.csv) file.');
                this.value = '';
                return;
            }
        }
    });
});
</script>
@endpush
