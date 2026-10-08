<link rel="stylesheet" href="{{ asset('css/wa.css') }}">

<div class="wa-sticky-wrapper">
    <div class="wa-circle-row">
        {{-- CS 1: NHC --}}
        @php
            $pesan = urlencode('Halo, saya ingin bertanya seputar program di Brilliant English Course.');
        @endphp
        <a href="https://wa.me/62811398843?text={{ $pesan }}" class="wa-circle tooltip" target="_blank">
            <img src="{{ asset('asset/wa/WhatsApp.svg') }}" alt="WA">
            <span class="tooltip-text">Admin NHC</span>
        </a>

        {{-- CS 2: Officer dari database id 1 --}}
        @if(isset($contactServices))
            @php
                $cs2 = collect($contactServices)->firstWhere('id', 1);
            @endphp
            @if($cs2)
                <a href="https://wa.me/62{{ $cs2->nomor }}?text={{ $pesan }}" class="wa-circle tooltip" target="_blank">
                    <img src="{{ asset('asset/wa/WhatsApp.svg') }}" alt="WA">
                    <span class="tooltip-text">{{ $cs2->nama }}</span>
                </a>
            @endif
        @endif
    </div>
</div>

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
