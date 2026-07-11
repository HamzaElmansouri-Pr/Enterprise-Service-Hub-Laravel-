@props(['title_target' => '[name=\'title[en]\']', 'content_target' => '[name=\'content[en]\']'])

<div class="card bg-light border-0 mb-4" id="seoAnalyzerContainer">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0 text-primary"><i class="fas fa-search-chart me-2"></i>AI SEO Analyzer</h6>
            <button type="button" class="btn btn-sm btn-primary" id="btnAnalyzeSeo" onclick="analyzeSeo()">
                <i class="fas fa-magic me-1"></i> Analyze & Generate SEO
            </button>
        </div>

        <div id="seoResults" class="d-none">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">SEO Score</span>
                        <span class="small" id="seoScoreText">0/100</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div id="seoScoreBar" class="progress-bar bg-success" role="progressbar" style="width: 0%;"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Readability</span>
                        <span class="small" id="readabilityScoreText">0/100</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div id="readabilityScoreBar" class="progress-bar bg-info" role="progressbar" style="width: 0%;"></div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <span class="small fw-bold d-block mb-2">Focus Keywords:</span>
                <div id="focusKeywordsList" class="d-flex flex-wrap gap-1">
                    <!-- Badges will be injected here -->
                </div>
            </div>

            <div class="mb-3">
                <span class="small fw-bold d-block mb-2">Recommendations:</span>
                <ul id="seoSuggestionsList" class="small text-muted mb-0 ps-3">
                    <!-- Suggestions will be injected here -->
                </ul>
            </div>
            
            <div class="alert alert-success py-2 px-3 mb-0 small">
                <i class="fas fa-check-circle me-1"></i> Meta Title and Description have been automatically populated based on the analysis.
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
async function analyzeSeo() {
    const titleEl = document.querySelector("{{ $title_target }}");
    const contentEl = document.querySelector("{{ $content_target }}");
    
    let title = titleEl ? titleEl.value : '';
    let content = contentEl ? contentEl.value : '';

    // If using a rich text editor like Summernote or TinyMCE, we might need to get content differently.
    // Assuming simple textarea or relying on standard value.
    if (!content) {
        alert("Please ensure there is content to analyze.");
        return;
    }

    const btn = document.getElementById('btnAnalyzeSeo');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Analyzing...';
    btn.disabled = true;
    
    // Hide results initially
    document.getElementById('seoResults').classList.add('d-none');

    try {
        const response = await fetch('{{ route("admin.ai.seo-analyze") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ title: title, content: content })
        });

        if (!response.ok) throw new Error('Failed to analyze SEO');

        const data = await response.json();
        
        // Populate Meta fields
        const metaTitleEl = document.querySelector('[name="meta_title[en]"]') || document.querySelector('[name="meta_title"]');
        const metaDescEl = document.querySelector('[name="meta_description[en]"]') || document.querySelector('[name="meta_description"]');
        
        if (metaTitleEl && data.meta_title) metaTitleEl.value = data.meta_title;
        if (metaDescEl && data.meta_description) metaDescEl.value = data.meta_description;
        
        // Update Dashboard UI
        const seoScore = data.seo_score || 0;
        const readScore = data.readability_score || 0;
        
        document.getElementById('seoScoreText').innerText = seoScore + '/100';
        const seoBar = document.getElementById('seoScoreBar');
        seoBar.style.width = seoScore + '%';
        seoBar.className = 'progress-bar ' + (seoScore > 75 ? 'bg-success' : (seoScore > 40 ? 'bg-warning' : 'bg-danger'));

        document.getElementById('readabilityScoreText').innerText = readScore + '/100';
        const readBar = document.getElementById('readabilityScoreBar');
        readBar.style.width = readScore + '%';
        readBar.className = 'progress-bar ' + (readScore > 75 ? 'bg-info' : (readScore > 40 ? 'bg-primary' : 'bg-secondary'));
        
        // Keywords
        const keywordsContainer = document.getElementById('focusKeywordsList');
        keywordsContainer.innerHTML = '';
        if (data.focus_keywords && Array.isArray(data.focus_keywords)) {
            data.focus_keywords.forEach(kw => {
                const span = document.createElement('span');
                span.className = 'badge bg-secondary';
                span.innerText = kw;
                keywordsContainer.appendChild(span);
            });
        }
        
        // Suggestions
        const suggestionsList = document.getElementById('seoSuggestionsList');
        suggestionsList.innerHTML = '';
        if (data.suggestions && Array.isArray(data.suggestions)) {
            data.suggestions.forEach(sug => {
                const li = document.createElement('li');
                li.innerText = sug;
                suggestionsList.appendChild(li);
            });
        }

        // Show Results
        document.getElementById('seoResults').classList.remove('d-none');

    } catch (e) {
        alert('An error occurred during SEO analysis: ' + e.message);
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
}
</script>
@endpush
