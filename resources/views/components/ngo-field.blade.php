@props([
    'name',
    'label',
    'type' => 'text',
    'required' => false,
    'placeholder' => '',
    'hint' => null,
    'rows' => 3,
    'col' => 'col-lg-6',
    'accept' => 'image/png,image/jpeg,image/webp',
    'maxlength' => null,
    'inputmode' => null,
    'value' => null,
])

{{-- One labelled field of the NGO registration form (resources/views/pages/ngo-register.blade.php).
     $name may use dot notation for nested fields (e.g. social_links.facebook). --}}
@php
    $dotName = $name;
    $htmlName = preg_replace('/\.([^.]+)/', '[$1]', $name);
    $id = 'f_'.str_replace('.', '_', $name);
    $hasError = $errors->has($dotName);
@endphp

<div class="{{ $col }}">
    <label for="{{ $id }}" class="ngo-label">{{ $label }} @if ($required)<span class="text-danger">*</span>@endif</label>
    <div class="form-clt">
        @if ($type === 'textarea')
            <textarea name="{{ $htmlName }}" id="{{ $id }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
                      @if ($maxlength) maxlength="{{ $maxlength }}" @endif
                      @if ($required) required @endif
                      class="{{ $hasError ? 'is-invalid' : '' }}">{{ old($dotName, $value) }}</textarea>
        @elseif ($type === 'file')
            <input type="file" name="{{ $htmlName }}" id="{{ $id }}" accept="{{ $accept }}"
                   class="ngo-file {{ $hasError ? 'is-invalid' : '' }}">
        @else
            <input type="{{ $type }}" name="{{ $htmlName }}" id="{{ $id }}" placeholder="{{ $placeholder }}"
                   value="{{ old($dotName, $value) }}"
                   @if ($maxlength) maxlength="{{ $maxlength }}" @endif
                   @if ($inputmode) inputmode="{{ $inputmode }}" @endif
                   @if ($required) required @endif
                   class="{{ $hasError ? 'is-invalid' : '' }}">
        @endif
    </div>
    @if ($hint)
        <div class="ngo-hint">{{ $hint }}</div>
    @endif
    @error($dotName)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
