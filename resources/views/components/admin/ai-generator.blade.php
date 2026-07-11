@props(['target', 'context_target', 'type' => 'blog_body', 'label' => 'Generate with AI'])

<div class="card bg-light border-primary border-opacity-25 mb-3 shadow-sm ai-generator-panel" data-target="{{ $target }}" data-context-target="{{ $context_target }}" data-type="{{ $type }}">
    <div class="card-body p-3">
        <div class="d-flex align-items-center mb-3">
            <i class="fas fa-robot text-primary fa-lg me-2"></i>
            <h6 class="mb-0 fw-bold text-primary">AI Content Generator</h6>
        </div>
        
        <div class="row g-2 mb-3">
            <div class="col-md-4">
                <label class="form-label small text-muted mb-1">Tone</label>
                <select class="form-select form-select-sm ai-tone">
                    <option value="professional" selected>Professional</option>
                    <option value="casual">Casual</option>
                    <option value="technical">Technical</option>
                    <option value="persuasive">Persuasive</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small text-muted mb-1">Length</label>
                <select class="form-select form-select-sm ai-length">
                    <option value="short">Short (~100 words)</option>
                    <option value="medium" selected>Medium (~300 words)</option>
                    <option value="long">Long (~600+ words)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small text-muted mb-1">Language</label>
                <select class="form-select form-select-sm ai-language">
                    <option value="en" selected>English (en)</option>
                    <option value="fr">Français (fr)</option>
                    <option value="ar">العربية (ar)</option>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-primary ai-generate-btn">
                <i class="fas fa-magic me-1"></i> {{ $label }}
            </button>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const aiPanels = document.querySelectorAll('.ai-generator-panel');
    
    aiPanels.forEach(panel => {
        const btn = panel.querySelector('.ai-generate-btn');
        const targetSelector = panel.dataset.target;
        const contextSelector = panel.dataset.contextTarget;
        const defaultType = panel.dataset.type;
        
        btn.addEventListener('click', async function() {
            // Find context value
            const contextEl = document.querySelector(contextSelector);
            if (!contextEl || !contextEl.value) {
                alert("Please enter a value in the context field (e.g. title) first so the AI knows what to write about.");
                return;
            }
            const context = contextEl.value;

            // Get options
            const tone = panel.querySelector('.ai-tone').value;
            const length = panel.querySelector('.ai-length').value;
            const language = panel.querySelector('.ai-language').value;

            // Determine target textarea. 
            // If the target is a translatable textarea, we need to append the language e.g. [name="content[en]"]
            let targetEl = document.querySelector(targetSelector);
            
            // Try to find language specific target if the basic one isn't found or if we want to be smart about translatable inputs
            if (!targetEl && targetSelector.includes('[name="')) {
                 // Try to inject language
                 const baseName = targetSelector.match(/name="([^"]+)"/)[1];
                 targetEl = document.querySelector(`[name="${baseName}[${language}]"]`);
            }

            if (!targetEl) {
                // Let's try appending language to a base selector if it's not a generic selector
                targetEl = document.querySelector(`${targetSelector}\\[${language}\\]`);
            }

            if (!targetEl) {
                // Final fallback, just use the exact selector again
                targetEl = document.querySelector(targetSelector);
            }

            if (!targetEl) {
                alert("Could not find the target field to output generated content.");
                return;
            }
            
            // If it's a translatable field in a tab, switch to that tab
            const tabEl = targetEl.closest('.tab-pane');
            if (tabEl) {
                const tabId = tabEl.id;
                const tabLink = document.querySelector(`a[href="#${tabId}"]`);
                if (tabLink) {
                    // Use bootstrap tab API if available, otherwise just click
                    if (typeof bootstrap !== 'undefined') {
                        const tab = new bootstrap.Tab(tabLink);
                        tab.show();
                    } else {
                        tabLink.click();
                    }
                }
            }

            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating...';
            btn.disabled = true;

            try {
                const response = await fetch('{{ route("admin.ai.generate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ 
                        type: defaultType, 
                        context: context,
                        tone: tone,
                        length: length,
                        language: language
                    })
                });

                if (!response.ok) throw new Error('API Error');

                const reader = response.body.getReader();
                const decoder = new TextDecoder("utf-8");
                
                // Clear existing content if not appending
                if (typeof tinymce !== 'undefined' && targetEl.id && tinymce.get(targetEl.id)) {
                    tinymce.get(targetEl.id).setContent('');
                } else {
                    targetEl.value = ""; 
                }

                while (true) {
                    const { value, done } = await reader.read();
                    if (done) break;

                    const chunk = decoder.decode(value, { stream: true });
                    const lines = chunk.split("\n");

                    for (let line of lines) {
                        if (line.startsWith('data: ')) {
                            const dataStr = line.substring(6).trim();
                            if (dataStr === '[DONE]') {
                                break;
                            }
                            try {
                                const data = JSON.parse(dataStr);
                                if (data.chunk) {
                                    if (typeof tinymce !== 'undefined' && targetEl.id && tinymce.get(targetEl.id)) {
                                        let editor = tinymce.get(targetEl.id);
                                        let current = editor.getContent({format: 'html'});
                                        editor.setContent(current + data.chunk);
                                    } else {
                                        targetEl.value += data.chunk;
                                    }
                                }
                            } catch (e) {
                                // Incomplete chunk parse error, ignore and let buffer catch up
                            }
                        }
                    }
                }
                
                // Trigger input event for anything listening (like live previews or character counters)
                targetEl.dispatchEvent(new Event('input', { bubbles: true }));
                
                btn.innerHTML = '<i class="fas fa-sync me-1"></i> Regenerate';
            } catch (e) {
                alert('An error occurred during AI generation: ' + e.message);
                btn.innerHTML = originalText;
            } finally {
                btn.disabled = false;
            }
        });
    });
});
</script>
@endpush
@endonce
