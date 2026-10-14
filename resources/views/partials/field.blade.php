@php
    $type ??= 'text';
    $required ??= false;
    $invalid = $errors->has($name);
@endphp
<div class="field">
    <label for="{{ $name }}">{{ $label }} @unless ($required)<span class="optional">(optional)</span>@endunless</label>
    <input class="input" type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}"
        @if ($required) required data-required="{{ $requiredMessage ?? 'This field is required.' }}" @endif
        @isset($autocomplete) autocomplete="{{ $autocomplete }}" @endisset
        @isset($pattern) pattern="{{ $pattern }}" data-pattern="{{ $patternMessage ?? '' }}" @endisset
        maxlength="{{ $type === 'email' ? 190 : 160 }}"
        aria-describedby="{{ $name }}-error"
        @if ($invalid) aria-invalid="true" @endif>
    <p class="error" id="{{ $name }}-error" @unless ($invalid) hidden @endunless>{{ $errors->first($name) }}</p>
</div>
