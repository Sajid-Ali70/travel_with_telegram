@php
    $whatsAppNumber = preg_replace('/\D+/', '', (string) ($settings->phone ?? ''));
@endphp

@if($whatsAppNumber !== '')
    <a class="whatsapp-float" href="https://wa.me/{{ $whatsAppNumber }}" target="_blank" rel="noopener noreferrer" aria-label="Chat with us on WhatsApp">
        <i class="fab fa-whatsapp" aria-hidden="true"></i>
        <span>WhatsApp</span>
    </a>
@endif
