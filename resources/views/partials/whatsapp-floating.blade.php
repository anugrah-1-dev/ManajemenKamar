<link rel="stylesheet" href="{{ asset('css/wa.css') }}">

@if (isset($contactServices) && count($contactServices))
    <div class="wa-sticky-wrapper">
        <div class="wa-circle-row">
            @foreach ($contactServices as $contact)
            
                @php
                    $pesan = urlencode('Halo, saya ingin bertanya seputar program di Brilliant English Course.');
                @endphp

                <a href="https://wa.me/62{{ $contact->nomor }}?text={{ $pesan }}" class="wa-circle tooltip"
                    target="_blank">
                    <img src="{{ asset('asset/wa/WhatsApp.svg') }}" alt="WA">
                    <span class="tooltip-text">{{ $contact->nama }}</span>
                </a>
            @endforeach
        </div>
    </div>
@endif

<script>
    // Tooltip effect
    document.querySelectorAll('.wa-circle.tooltip').forEach(function(el) {
        el.addEventListener('mouseenter', function() {
            const tooltip = el.querySelector('.tooltip-text');
            tooltip.style.visibility = 'visible';
            tooltip.style.opacity = '1';
        });
        el.addEventListener('mouseleave', function() {
            const tooltip = el.querySelector('.tooltip-text');
            tooltip.style.visibility = 'hidden';
            tooltip.style.opacity = '0';
        });
    });
</script>
