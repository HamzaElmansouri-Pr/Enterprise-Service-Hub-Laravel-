@props(['categories' => [], 'selected' => []])

@php
    $selectedIds = collect(old('category_ids', $selected))->map(fn($id) => (int)$id)->all();
@endphp

<div class="category-multiselect-widget" id="categoryMultiselectWidget">
    <input type="hidden" name="categories_submitted" value="1">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="form-label mb-0 fw-bold d-flex align-items-center gap-2">
            <span><i class="fas fa-tags text-primary me-1"></i> Categories</span>
            <span class="badge rounded-pill bg-primary px-2 py-1" id="categoryCountBadge" style="font-size: 0.75rem;">
                {{ count($selectedIds) }} selected
            </span>
        </label>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 text-muted" id="selectAllCategoriesBtn" style="font-size: 0.8rem;">
                Select all
            </button>
            <span class="text-muted small">•</span>
            <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 text-muted" id="clearCategoriesBtn" style="font-size: 0.8rem;">
                Clear
            </button>
            <span class="text-muted small">•</span>
            <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill" id="toggleQuickAddBtn" style="font-size: 0.78rem;">
                <i class="fas fa-plus me-1"></i>New
            </button>
        </div>
    </div>

    <!-- Quick Add Category Inline Form (hidden by default) -->
    <div id="quickAddCategoryBox" class="p-2 mb-2 bg-light border rounded d-none">
        <div class="input-group input-group-sm">
            <input type="text" id="quickCategoryNameInput" class="form-control" placeholder="New category name (e.g. AI & Automation)">
            <button type="button" class="btn btn-primary" id="saveQuickCategoryBtn">
                <i class="fas fa-check me-1"></i>Add
            </button>
            <button type="button" class="btn btn-outline-secondary" id="cancelQuickCategoryBtn">
                Cancel
            </button>
        </div>
        <div id="quickCategoryError" class="text-danger small mt-1 d-none"></div>
    </div>

    <!-- Filter Search for Categories if multiple exist -->
    @if(count($categories) > 4)
    <div class="mb-2">
        <div class="input-group input-group-sm">
            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
            <input type="text" id="categoryFilterInput" class="form-control border-start-0" placeholder="Filter categories...">
        </div>
    </div>
    @endif

    <!-- Pills Box -->
    <div class="border rounded p-3 bg-white shadow-sm" style="min-height: 75px;">
        <div id="categoriesPillsContainer" class="d-flex flex-wrap gap-2">
            @forelse($categories as $category)
                @php
                    $catId = (int)$category->id;
                    $isSelected = in_array($catId, $selectedIds);
                    $catName = get_content_value($category->name);
                @endphp
                <div class="category-pill-item" data-category-id="{{ $catId }}" data-category-name="{{ strtolower($catName) }}">
                    <input type="checkbox" 
                           name="category_ids[]" 
                           value="{{ $catId }}" 
                           id="cat_input_{{ $catId }}" 
                           class="d-none category-checkbox" 
                           {{ $isSelected ? 'checked' : '' }}>
                    <button type="button" 
                            class="btn btn-sm rounded-pill category-pill-btn transition-all {{ $isSelected ? 'btn-primary' : 'btn-outline-secondary border-dashed' }}"
                            data-category-id="{{ $catId }}">
                        <i class="fas {{ $isSelected ? 'fa-check-circle' : 'fa-plus' }} me-1 status-icon"></i>
                        <span class="cat-label">{{ $catName }}</span>
                        @if($isSelected)
                            <i class="fas fa-times ms-2 opacity-75 remove-icon"></i>
                        @endif
                    </button>
                </div>
            @empty
                <div id="emptyCategoriesPlaceholder" class="text-muted small py-2 w-100 text-center">
                    <i class="fas fa-tag me-1"></i> No categories created yet. Click <strong>+ New</strong> above to add one.
                </div>
            @endforelse
        </div>
        <div id="noMatchingCategoryMsg" class="text-muted small text-center py-2 d-none">
            No categories match your search.
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-2 px-1">
        <span class="text-muted small">
            <i class="fas fa-info-circle me-1"></i>Click any category to toggle it. You can select one, multiple, or none.
        </span>
        <a href="{{ route('admin.categories.index') }}" target="_blank" class="small text-decoration-none text-muted" style="font-size: 0.78rem;">
            Manage all <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
        </a>
    </div>

    @error('category_ids')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const widget = document.getElementById('categoryMultiselectWidget');
    if (!widget) return;

    const pillsContainer = document.getElementById('categoriesPillsContainer');
    const badge = document.getElementById('categoryCountBadge');
    const filterInput = document.getElementById('categoryFilterInput');
    const noMatchMsg = document.getElementById('noMatchingCategoryMsg');
    const selectAllBtn = document.getElementById('selectAllCategoriesBtn');
    const clearBtn = document.getElementById('clearCategoriesBtn');
    const toggleQuickAddBtn = document.getElementById('toggleQuickAddBtn');
    const quickAddBox = document.getElementById('quickAddCategoryBox');
    const quickInput = document.getElementById('quickCategoryNameInput');
    const saveQuickBtn = document.getElementById('saveQuickCategoryBtn');
    const cancelQuickBtn = document.getElementById('cancelQuickCategoryBtn');
    const quickError = document.getElementById('quickCategoryError');

    function updateCount() {
        const checked = widget.querySelectorAll('.category-checkbox:checked').length;
        if (checked === 0) {
            badge.textContent = 'None';
            badge.className = 'badge rounded-pill bg-secondary-subtle text-secondary px-2 py-1';
        } else if (checked === 1) {
            badge.textContent = '1 selected';
            badge.className = 'badge rounded-pill bg-primary px-2 py-1';
        } else {
            badge.textContent = checked + ' selected';
            badge.className = 'badge rounded-pill bg-primary px-2 py-1';
        }
    }

    function togglePill(btn) {
        const catId = btn.getAttribute('data-category-id');
        const checkbox = document.getElementById('cat_input_' + catId);
        if (!checkbox) return;

        checkbox.checked = !checkbox.checked;
        const isSelected = checkbox.checked;

        if (isSelected) {
            btn.className = 'btn btn-sm rounded-pill category-pill-btn transition-all btn-primary';
            btn.innerHTML = `<i class="fas fa-check-circle me-1 status-icon"></i><span class="cat-label">${btn.querySelector('.cat-label').textContent}</span><i class="fas fa-times ms-2 opacity-75 remove-icon"></i>`;
        } else {
            btn.className = 'btn btn-sm rounded-pill category-pill-btn transition-all btn-outline-secondary border-dashed';
            btn.innerHTML = `<i class="fas fa-plus me-1 status-icon"></i><span class="cat-label">${btn.querySelector('.cat-label').textContent}</span>`;
        }

        updateCount();
    }

    pillsContainer.addEventListener('click', function (e) {
        const btn = e.target.closest('.category-pill-btn');
        if (btn) {
            e.preventDefault();
            togglePill(btn);
        }
    });

    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function (e) {
            e.preventDefault();
            widget.querySelectorAll('.category-pill-item').forEach(function (item) {
                const btn = item.querySelector('.category-pill-btn');
                const checkbox = item.querySelector('.category-checkbox');
                if (btn && checkbox && !checkbox.checked) {
                    togglePill(btn);
                }
            });
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function (e) {
            e.preventDefault();
            widget.querySelectorAll('.category-pill-item').forEach(function (item) {
                const btn = item.querySelector('.category-pill-btn');
                const checkbox = item.querySelector('.category-checkbox');
                if (btn && checkbox && checkbox.checked) {
                    togglePill(btn);
                }
            });
        });
    }

    if (filterInput) {
        filterInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            let visibleCount = 0;

            widget.querySelectorAll('.category-pill-item').forEach(function (item) {
                const name = item.getAttribute('data-category-name') || '';
                if (name.includes(query)) {
                    item.classList.remove('d-none');
                    visibleCount++;
                } else {
                    item.classList.add('d-none');
                }
            });

            if (noMatchMsg) {
                if (visibleCount === 0 && query !== '') {
                    noMatchMsg.classList.remove('d-none');
                } else {
                    noMatchMsg.classList.add('d-none');
                }
            }
        });
    }

    // Quick Add Category Feature
    if (toggleQuickAddBtn && quickAddBox) {
        toggleQuickAddBtn.addEventListener('click', function () {
            quickAddBox.classList.toggle('d-none');
            if (!quickAddBox.classList.contains('d-none')) {
                quickInput.focus();
            }
        });
    }

    if (cancelQuickBtn && quickAddBox) {
        cancelQuickBtn.addEventListener('click', function () {
            quickAddBox.classList.add('d-none');
            quickInput.value = '';
            if (quickError) quickError.classList.add('d-none');
        });
    }

    if (saveQuickBtn && quickInput) {
        saveQuickBtn.addEventListener('click', function () {
            const name = quickInput.value.trim();
            if (!name) return;

            saveQuickBtn.disabled = true;
            if (quickError) quickError.classList.add('d-none');

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
                || document.querySelector('input[name="_token"]')?.value;

            fetch('{{ route("admin.categories.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    name: { en: name, ar: name, fr: name },
                    is_active: true
                })
            })
            .then(res => res.json())
            .then(data => {
                saveQuickBtn.disabled = false;
                if (data.success && data.category) {
                    const cat = data.category;
                    const placeholder = document.getElementById('emptyCategoriesPlaceholder');
                    if (placeholder) placeholder.remove();

                    // Create new pill element
                    const item = document.createElement('div');
                    item.className = 'category-pill-item';
                    item.setAttribute('data-category-id', cat.id);
                    item.setAttribute('data-category-name', cat.name.toLowerCase());
                    item.innerHTML = `
                        <input type="checkbox" name="category_ids[]" value="${cat.id}" id="cat_input_${cat.id}" class="d-none category-checkbox" checked>
                        <button type="button" class="btn btn-sm rounded-pill category-pill-btn transition-all btn-primary" data-category-id="${cat.id}">
                            <i class="fas fa-check-circle me-1 status-icon"></i>
                            <span class="cat-label">${cat.name}</span>
                            <i class="fas fa-times ms-2 opacity-75 remove-icon"></i>
                        </button>
                    `;
                    pillsContainer.appendChild(item);

                    quickInput.value = '';
                    quickAddBox.classList.add('d-none');
                    updateCount();
                } else {
                    if (quickError) {
                        quickError.textContent = data.message || 'Failed to add category.';
                        quickError.classList.remove('d-none');
                    }
                }
            })
            .catch(err => {
                saveQuickBtn.disabled = false;
                if (quickError) {
                    quickError.textContent = 'An error occurred while creating category.';
                    quickError.classList.remove('d-none');
                }
            });
        });

        quickInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                saveQuickBtn.click();
            }
        });
    }

    updateCount();
});
</script>

<style>
.category-pill-btn {
    padding: 0.35rem 0.85rem;
    font-size: 0.83rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
}
.category-pill-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}
.category-pill-btn.btn-primary {
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    border-color: #4f46e5;
    color: #ffffff;
}
.category-pill-btn.btn-outline-secondary {
    background-color: #f8fafc;
    border-color: #cbd5e1;
    color: #334155;
}
.category-pill-btn.btn-outline-secondary:hover {
    background-color: #eff6ff;
    border-color: #6366f1;
    color: #4f46e5;
}
.border-dashed {
    border-style: dashed !important;
}
</style>
