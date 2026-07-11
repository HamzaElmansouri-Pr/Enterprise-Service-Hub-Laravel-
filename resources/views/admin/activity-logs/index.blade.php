@extends('admin.layouts.app')

@section('title', 'Activity Logs')
@section('page-title', 'System Activity Logs')

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 3rem;
        margin-bottom: 2rem;
    }
    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 1.5rem;
        width: 2px;
        background: rgba(0, 0, 0, 0.1);
    }
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    .timeline-icon {
        position: absolute;
        left: -3rem;
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        background: #fff;
        border: 2px solid var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .timeline-content {
        background: #fff;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.05);
    }
    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.5rem;
    }
    .timeline-time {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    [data-bs-theme="dark"] .timeline-content {
        background: #242424;
        border-color: #333;
    }
    [data-bs-theme="dark"] .timeline-icon {
        background: #242424;
        border-color: #4e73df;
    }
    
    .diff-container pre {
        margin: 0;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 6px;
        font-size: 0.85rem;
        max-height: 200px;
        overflow-y: auto;
    }
    [data-bs-theme="dark"] .diff-container pre {
        background: #1a1a1a;
        color: #e0e0e0;
    }
    .diff-add { color: #198754; background: rgba(25, 135, 84, 0.1); display: block; }
    .diff-remove { color: #dc3545; background: rgba(220, 53, 69, 0.1); text-decoration: line-through; display: block; }
    
    [data-bs-theme="dark"] .diff-add { color: #75b798; }
    [data-bs-theme="dark"] .diff-remove { color: #ea868f; }
</style>
@endpush

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-filter me-2 text-primary"></i>Filter Logs</h5>
                <a href="{{ route('admin.activity-logs.export', request()->all()) }}" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                    <i class="fas fa-file-csv me-1"></i> Export CSV
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.activity-logs.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small text-muted">User</label>
                        <select name="causer_id" class="form-select form-select-sm">
                            <option value="">All Users</option>
                            @foreach($users as $id => $name)
                                <option value="{{ $id }}" {{ request('causer_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                            <option value="system" {{ request('causer_id') === 'system' ? 'selected' : '' }}>System (No User)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Entity Type</label>
                        <select name="subject_type" class="form-select form-select-sm">
                            <option value="">All Entities</option>
                            @foreach($entityTypes as $fullType => $baseType)
                                <option value="{{ $baseType }}" {{ request('subject_type') == $baseType ? 'selected' : '' }}>{{ $baseType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted">Action</label>
                        <select name="log_name" class="form-select form-select-sm">
                            <option value="">All Actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('log_name') == $action ? 'selected' : '' }}>{{ ucfirst($action) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Date Range</label>
                        <div class="input-group input-group-sm">
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            <span class="input-group-text">to</span>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                @if($logs->count() > 0)
                    <div class="timeline mt-3">
                        @foreach($logs as $log)
                            @php
                                // Determine icon and color based on log_name/action
                                $icon = 'fa-info';
                                $colorClass = 'text-primary';
                                
                                if(str_contains(strtolower($log->log_name ?? $log->description), 'create') || str_contains(strtolower($log->log_name ?? $log->description), 'add')) {
                                    $icon = 'fa-plus';
                                    $colorClass = 'text-success';
                                } elseif(str_contains(strtolower($log->log_name ?? $log->description), 'update') || str_contains(strtolower($log->log_name ?? $log->description), 'edit')) {
                                    $icon = 'fa-pencil-alt';
                                    $colorClass = 'text-warning';
                                } elseif(str_contains(strtolower($log->log_name ?? $log->description), 'delete') || str_contains(strtolower($log->log_name ?? $log->description), 'trash')) {
                                    $icon = 'fa-trash';
                                    $colorClass = 'text-danger';
                                } elseif(str_contains(strtolower($log->log_name ?? $log->description), 'login')) {
                                    $icon = 'fa-sign-in-alt';
                                    $colorClass = 'text-info';
                                }
                            @endphp
                            
                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="fas {{ $icon }} {{ $colorClass }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <div>
                                            <h6 class="mb-1 fw-bold">
                                                {{ ucfirst($log->description) }}
                                            </h6>
                                            <div class="small text-muted mb-2">
                                                <i class="fas fa-user-circle me-1"></i> 
                                                <strong>{{ $log->causer ? $log->causer->name : 'System User' }}</strong>
                                                
                                                @if($log->subject_type)
                                                    <span class="mx-2">&bull;</span>
                                                    <i class="fas fa-cube me-1"></i> 
                                                    {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                                                @endif
                                                
                                                <span class="badge bg-light text-dark border ms-2">{{ $log->log_name }}</span>
                                            </div>
                                        </div>
                                        <div class="timeline-time text-end">
                                            <i class="far fa-clock me-1"></i> {{ $log->created_at->diffForHumans() }}
                                            <div class="small text-muted">{{ $log->created_at->format('M d, Y H:i:s') }}</div>
                                        </div>
                                    </div>
                                    
                                    @if($log->properties && count($log->properties) > 0)
                                        <div class="mt-3 diff-container">
                                            <a class="btn btn-sm btn-outline-secondary mb-2" data-bs-toggle="collapse" href="#properties-{{ $log->id }}">
                                                <i class="fas fa-code me-1"></i> View Changes Data
                                            </a>
                                            <div class="collapse" id="properties-{{ $log->id }}">
                                                <pre><code>@php
                                                    $props = is_string($log->properties) ? json_decode($log->properties, true) : $log->properties;
                                                    
                                                    // Simple diff representation if old and attributes exist
                                                    if (isset($props['old']) && isset($props['attributes'])) {
                                                        foreach ($props['attributes'] as $key => $newValue) {
                                                            $oldValue = $props['old'][$key] ?? null;
                                                            if ($oldValue !== $newValue) {
                                                                echo "<div class='mb-2'>";
                                                                echo "<strong>Field: {$key}</strong><br>";
                                                                echo "<span class='diff-remove'>- " . htmlentities(is_array($oldValue) ? json_encode($oldValue) : (string)$oldValue) . "</span>";
                                                                echo "<span class='diff-add'>+ " . htmlentities(is_array($newValue) ? json_encode($newValue) : (string)$newValue) . "</span>";
                                                                echo "</div>";
                                                            }
                                                        }
                                                    } else {
                                                        echo json_encode($props, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                                                    }
                                                @endphp</code></pre>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $logs->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="display-1 text-muted mb-3 opacity-25"><i class="fas fa-clipboard-list"></i></div>
                        <h5>No Activity Logs Found</h5>
                        <p class="text-muted">There are no records matching your current filters.</p>
                        @if(request()->anyFilled(['causer_id', 'subject_type', 'log_name', 'start_date', 'end_date']))
                            <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-primary mt-2">Clear Filters</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
