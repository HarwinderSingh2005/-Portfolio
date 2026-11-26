{{-- Inline SVG icon set (Lucide style) with gradient strokes, per-icon accent colours
     and hover animations. Usage:
     <x-icon name="github" />
     <x-icon name="mail" hover="spin" class="h-5 w-5" />
     <x-icon name="code" tone="rose" :gradient="false" /> --}}
@props([
    'name' => 'layers',
    'tone' => null,
    'gradient' => true,
    'hover' => 'lift',
])

@php
    $name = strtolower(str_replace('_', '-', $name));

    // Accent colour and a second colour used for the gradient stroke
    $palette = [
        'cyan' => ['#22D3EE', '#6366F1'],
        'indigo' => ['#6366F1', '#E879F9'],
        'fuchsia' => ['#E879F9', '#FB7185'],
        'rose' => ['#FB7185', '#FACC15'],
        'amber' => ['#FACC15', '#A3E635'],
        'lime' => ['#A3E635', '#22D3EE'],
    ];

    $defaultTone = [
        'menu' => 'cyan', 'x' => 'rose', 'arrow-right' => 'cyan', 'arrow-down' => 'cyan',
        'arrow-up' => 'cyan', 'arrow-up-right' => 'cyan', 'download' => 'lime', 'mail' => 'fuchsia',
        'phone' => 'amber', 'map-pin' => 'rose', 'github' => 'indigo', 'linkedin' => 'indigo',
        'send' => 'cyan', 'circle-check' => 'lime', 'briefcase' => 'amber', 'graduation-cap' => 'fuchsia',
        'code' => 'cyan', 'database' => 'indigo', 'server' => 'indigo', 'webhook' => 'rose',
        'terminal' => 'lime', 'layers' => 'indigo', 'globe' => 'cyan', 'layout-dashboard' => 'fuchsia',
        'shopping-bag' => 'amber', 'credit-card' => 'rose', 'smartphone' => 'indigo',
    ];

    $supported = array_keys($defaultTone);
    $icon = in_array($name, $supported, true) ? $name : 'layers';

    $toneKey = array_key_exists($tone, $palette) ? $tone : ($defaultTone[$icon] ?? 'indigo');
    [$from, $to] = $palette[$toneKey];

    $uid = 'ui-grad-'.\Illuminate\Support\Str::random(6);
    $hoverClass = in_array($hover, ['lift', 'spin', 'pulse', 'none'], true) ? $hover : 'lift';
@endphp

@once
    <style>
        .ui-icon {
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), filter 0.35s ease, opacity 0.35s ease;
            transform-origin: center;
            overflow: visible;
        }

        .ui-icon-lift:hover,
        .group:hover .ui-icon-lift {
            transform: translateY(-2px) scale(1.14);
            filter: drop-shadow(0 0 6px var(--ui-glow, #22D3EE)) drop-shadow(0 0 14px var(--ui-glow, #22D3EE));
        }

        .ui-icon-spin:hover,
        .group:hover .ui-icon-spin {
            transform: rotate(180deg) scale(1.1);
            filter: drop-shadow(0 0 8px var(--ui-glow, #22D3EE));
        }

        .ui-icon-pulse {
            animation: ui-icon-pulse 2.6s ease-in-out infinite;
        }

        .ui-icon-pulse:hover {
            animation-play-state: paused;
            transform: scale(1.15);
            filter: drop-shadow(0 0 10px var(--ui-glow, #22D3EE));
        }

        @keyframes ui-icon-pulse {
            0%, 100% { opacity: 0.85; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.06); }
        }

        @media (prefers-reduced-motion: reduce) {
            .ui-icon,
            .ui-icon-pulse {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
@endonce

<svg viewBox="0 0 24 24" fill="none"
    stroke="{{ $gradient ? 'url(#'.$uid.')' : 'currentColor' }}"
    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
    aria-hidden="true"
    {{ $attributes
        ->class(['ui-icon', 'ui-icon-'.$hoverClass])
        ->merge(['style' => "color: {$from}; --ui-glow: {$from};"]) }}>

    @if ($gradient)
        <defs>
            <linearGradient id="{{ $uid }}" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="{{ $from }}" />
                <stop offset="1" stop-color="{{ $to }}" />
            </linearGradient>
        </defs>
    @endif

    @switch($icon)
        @case('menu')
            <path d="M4 5h16M4 12h16M4 19h16" />
            @break
        @case('x')
            <path d="m18 6-12 12M6 6l12 12" />
            @break
        @case('arrow-right')
            <path d="M5 12h14m-7-7 7 7-7 7" />
            @break
        @case('arrow-down')
            <path d="M12 5v14m7-7-7 7-7-7" />
            @break
        @case('arrow-up')
            <path d="M12 19V5m-7 7 7-7 7 7" />
            @break
        @case('arrow-up-right')
            <path d="M7 17 17 7M7 7h10v10" />
            @break
        @case('download')
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
            <path d="m7 10 5 5 5-5M12 15V3" />
            @break
        @case('mail')
            <rect x="3" y="5" width="18" height="14" rx="2" />
            <path d="m3 7 9 6 9-6" />
            @break
        @case('phone')
            <path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.4 19.4 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7l.5 3.2a2 2 0 0 1-.6 1.7L7.1 10.5a16 16 0 0 0 6 6l1.9-1.9a2 2 0 0 1 1.7-.6l3.2.5a2 2 0 0 1 2.1 2.4Z" />
            @break
        @case('map-pin')
            <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z" />
            <circle cx="12" cy="10" r="2.5" />
            @break
        @case('github')
            <path d="M9 19c-4.3 1.4-4.3-2.5-6-3m12 6v-3.9a3.4 3.4 0 0 0-.9-2.7c3 0 6.1-1.5 6.1-6.7a5.2 5.2 0 0 0-1.4-3.6 4.8 4.8 0 0 0-.1-3.6s-1.1-.4-3.7 1.4a12.8 12.8 0 0 0-6.8 0C5.6 1.1 4.5 1.5 4.5 1.5a4.8 4.8 0 0 0-.1 3.6A5.2 5.2 0 0 0 3 8.7c0 5.2 3.1 6.7 6.1 6.7a3.4 3.4 0 0 0-.9 2.7V22" />
            @break
        @case('linkedin')
            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6ZM2 9h4v12H2z" />
            <circle cx="4" cy="4" r="2" />
            @break
        @case('send')
            <path d="m22 2-7 20-4-9-9-4Z" />
            <path d="M22 2 11 13" />
            @break
        @case('circle-check')
            <circle cx="12" cy="12" r="10" />
            <path d="m8 12 3 3 5-6" />
            @break
        @case('briefcase')
            <rect x="3" y="7" width="18" height="14" rx="2" />
            <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18m-12 0v2h6v-2" />
            @break
        @case('graduation-cap')
            <path d="m2 10 10-5 10 5-10 5-10-5Z" />
            <path d="M6 12v5c3.5 3 8.5 3 12 0v-5m4-2v6" />
            @break
        @case('code')
            <path d="m16 18 6-6-6-6M8 6l-6 6 6 6m6-16-4 20" />
            @break
        @case('database')
            <ellipse cx="12" cy="5" rx="9" ry="3" />
            <path d="M3 5v14c0 1.7 4 3 9 3s9-1.3 9-3V5M3 12c0 1.7 4 3 9 3s9-1.3 9-3" />
            @break
        @case('server')
            <rect x="3" y="3" width="18" height="8" rx="2" />
            <rect x="3" y="13" width="18" height="8" rx="2" />
            <path d="M7 7h.01M7 17h.01M11 7h6m-6 10h6" />
            @break
        @case('webhook')
            <path d="M18 8a3 3 0 1 0-3-3M6 8a3 3 0 1 1 3-3M12 21a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM7.5 7.5 10 12m4 0 2.5-4.5M7 17l-2-3.5m14 0L17 17" />
            @break
        @case('terminal')
            <path d="m4 17 6-6-6-6m8 14h8" />
            @break
        @case('globe')
            <circle cx="12" cy="12" r="10" />
            <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10Z" />
            @break
        @case('layout-dashboard')
            <rect x="3" y="3" width="8" height="8" rx="1" />
            <rect x="13" y="3" width="8" height="5" rx="1" />
            <rect x="13" y="10" width="8" height="11" rx="1" />
            <rect x="3" y="13" width="8" height="8" rx="1" />
            @break
        @case('shopping-bag')
            <path d="M6 7h12l1 14H5L6 7Z" />
            <path d="M9 7a3 3 0 0 1 6 0" />
            @break
        @case('credit-card')
            <rect x="2" y="5" width="20" height="14" rx="2" />
            <path d="M2 10h20M6 15h3" />
            @break
        @case('smartphone')
            <rect x="5" y="2" width="14" height="20" rx="2" />
            <path d="M11 18h2" />
            @break
        @default
            <path d="m12 2 9 5-9 5-9-5 9-5Zm-9 10 9 5 9-5M3 17l9 5 9-5" />
    @endswitch
</svg>