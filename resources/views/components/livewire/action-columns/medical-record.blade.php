<div class="inline-flex items-center mx-auto space-x-3">
    @role(['admin', 'doctor', 'opd'])
    <a
        href="{{ $viewLinkHistory ?? '#' }}"
        class="text-primary">
        View
    </a>

    @else
    <a
        href="{{ $viewLinkMedicalRecord ?? '#' }}"
        class="text-primary">
        View
    </a>
    @endrole
</div>