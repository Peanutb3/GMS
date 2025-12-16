@props(['type' => 'success', 'message'])

@php
$styles = [
'success' => 'bg-white text-gray-800',
'error' => 'bg-white text-gray-800',
'warning' => 'bg-white text-gray-800',
'info' => 'bg-white text-gray-800',
];

$currentStyle = $styles[$type] ?? $styles['info'];
@endphp

<!-- Fixed position toast below header at top right -->
<div class="!fixed !top-20 !right-4 !z-50 animate-fade-in" style="position: fixed !important; top: 5rem !important; right: 1rem !important; z-index: 9999 !important; width: calc(100% - 2rem); max-width: 24rem;">
    <div id="toast-{{ $type }}" class="relative flex items-center w-full max-w-sm p-4 rounded-lg shadow border border-gray-200 {{ $currentStyle }} overflow-hidden" role="alert">
        <!-- Timer Progress Bar -->
        <div class="absolute bottom-0 left-0 h-1
            @if($type === 'success') bg-green-500
            @elseif($type === 'error') bg-red-500
            @elseif($type === 'warning') bg-orange-500
            @else bg-blue-500
            @endif
            toast-timer-bar"></div>

        <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 mr-3 rounded-lg
            @if($type === 'success') bg-green-100 text-green-600
            @elseif($type === 'error') bg-red-100 text-red-600
            @elseif($type === 'warning') bg-orange-100 text-orange-600
            @else bg-blue-100 text-blue-600
            @endif">
            @if($type === 'success')
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
            @elseif($type === 'error')
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
            </svg>
            @elseif($type === 'warning')
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z" />
            </svg>
            @else
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            @endif
        </div>
        <div class="ms-3 text-sm font-normal flex-1">{{ $message }}</div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" onclick="this.closest('[role=alert]').parentElement.remove()" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }

    @keyframes timer-progress {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }

    .toast-timer-bar {
        animation: timer-progress 3s linear forwards;
    }
</style>

<script>
    // Auto-dismiss after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('[role="alert"]');
        toasts.forEach(function(toast) {
            const container = toast.parentElement;
            setTimeout(function() {
                container.style.transition = 'opacity 0.3s, transform 0.3s';
                container.style.opacity = '0';
                container.style.transform = 'translateX(20px)';
                setTimeout(function() {
                    container.remove();
                }, 300);
            }, 5000);
        });
    });
</script>