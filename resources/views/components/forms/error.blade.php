@props(['name'])

@error($name)
    <p class="text-xs text-red-500 italic mt-2">
        {{ $message }}
    </p>

@else
    <!-- Default error display (if no error is found, it remains empty) -->
    <p id="{{ $name }}-error" class="error-message text-xs text-red-500 italic mt-2">
        <!-- Placeholder for error message (if any) -->
    </p>
@enderror