@props(['name', 'label', 'value' => null, 'required' => false, 'placeholder' => '', 'rows' => 5, 'richtext' => false])

@php
    $locales = ['en' => 'English', 'fr' => 'Français', 'ar' => 'العربية'];
@endphp

<div class="mb-3">
    <label class="form-label">{{ $label }} @if($required) <span class="text-danger">*</span> @endif</label>
    
    <ul class="nav nav-tabs nav-sm mb-2" role="tablist" style="border-bottom: 1px solid #dee2e6;">
        @foreach($locales as $locale => $localeName)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $loop->first ? 'active' : '' }} py-1 px-3" data-bs-toggle="tab" href="#{{ $name }}_{{ $locale }}" role="tab">
                    <span class="d-none d-md-inline-block">{{ $localeName }}</span>
                    <span class="d-md-none">{{ strtoupper($locale) }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach($locales as $locale => $localeName)
            @php
                $val = '';
                if (old($name.'.'.$locale)) {
                    $val = old($name.'.'.$locale);
                } elseif (is_array($value) && isset($value[$locale])) {
                    $val = $value[$locale];
                } elseif (is_object($value) && method_exists($value, 'getTranslation')) {
                    $val = $value->getTranslation($name, $locale, false);
                } elseif (is_string($value) && $locale === 'en') {
                    $val = $value; // Fallback for plain strings
                }
            @endphp
            <div class="tab-pane {{ $loop->first ? 'active show' : '' }}" id="{{ $name }}_{{ $locale }}" role="tabpanel">
                <textarea name="{{ $name }}[{{ $locale }}]" 
                          id="{{ $name }}_{{ $locale }}_textarea"
                          class="form-control {{ $richtext ? 'richtext-editor' : '' }} @error($name.'.'.$locale) is-invalid @enderror" 
                          rows="{{ $rows }}"
                          data-locale="{{ $locale }}"
                          placeholder="{{ $placeholder }} ({{ strtoupper($locale) }})"
                          {{ $required && $locale === 'en' ? 'required' : '' }}>{{ $val }}</textarea>
                       
                @error($name.'.'.$locale) 
                    <div class="invalid-feedback">{{ $message }}</div> 
                @enderror
            </div>
        @endforeach
    </div>
</div>
