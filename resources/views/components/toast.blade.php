@props([
    'type' => 'success', // success, danger, warning, info
    'title' => 'Berhasil!',
    'message' => '',
    'delay' => 3000,
])

@php
    $colors = [
        'success' => ['bg' => 'bg-success', 'icon' => 'fas fa-check-circle'],
        'danger'  => ['bg' => 'bg-danger', 'icon' => 'fas fa-times-circle'],
        'warning' => ['bg' => 'bg-warning', 'icon' => 'fas fa-exclamation-triangle'],
        'info'    => ['bg' => 'bg-info', 'icon' => 'fas fa-info-circle'],
    ];
    $color = $colors[$type] ?? $colors['info'];
@endphp

<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
    <div class="toast show text-white {{ $color['bg'] }}" role="alert" data-bs-delay="{{ $delay }}" data-bs-autohide="true" aria-live="assertive" aria-atomic="true">
        <div class="toast-header {{ $color['bg'] }} text-white">
            <i class="{{ $color['icon'] }} me-2"></i>
            <strong class="me-auto">{{ $title }}</strong>
            <small>Baru saja</small>
            <button type="button" class="btn-close btn-close-white ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ $message }}
        </div>
    </div>
</div>
