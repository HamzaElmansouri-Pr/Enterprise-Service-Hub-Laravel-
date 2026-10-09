@extends('admin.layouts.app')

@section('title', 'Pages & SEO')
@section('page-title', 'Pages & SEO Manager')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card content-card-elite">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-file-alt text-primary me-2"></i> Manage Core Pages & SEO</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Page Name (Slug)</th>
                                <th>Meta Title</th>
                                <th>Meta Description</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $page)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $page->title }}</div>
                                    <div class="text-muted small text-uppercase">{{ $page->slug }}</div>
                                </td>
                                <td>
                                    @if($page->meta_title)
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $page->meta_title }}">{{ $page->meta_title }}</span>
                                    @else
                                        <span class="text-muted fst-italic">Not set</span>
                                    @endif
                                </td>
                                <td>
                                    @if($page->meta_description)
                                        <span class="text-truncate d-inline-block" style="max-width: 250px;" title="{{ $page->meta_description }}">{{ $page->meta_description }}</span>
                                    @else
                                        <span class="text-muted fst-italic">Not set</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> Edit SEO
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
