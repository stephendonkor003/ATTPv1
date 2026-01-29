@props(['style' => 'landing'])

@php
    $currentLocale = app()->getLocale();
    $locales = [
        'en' => ['name' => 'English', 'flag' => '🇬🇧'],
        'fr' => ['name' => 'Français', 'flag' => '🇫🇷'],
        'ar' => ['name' => 'العربية', 'flag' => '🇸🇦'],
        'pt' => ['name' => 'Português', 'flag' => '🇵🇹'],
        'es' => ['name' => 'Español', 'flag' => '🇪🇸'],
        'sw' => ['name' => 'Kiswahili', 'flag' => '🇰🇪'],
    ];
@endphp

@if($style === 'admin')
    {{-- Admin Header Style (Bootstrap 5 + NXL Theme) --}}
    <div class="dropdown nxl-h-item">
        <a href="javascript:void(0);" class="nxl-head-link me-0 language-toggle"
           data-bs-toggle="dropdown" role="button"
           aria-expanded="false">
            <i class="feather-globe"></i>
            <span class="d-none d-md-inline ms-1">{{ strtoupper($currentLocale) }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown language-dropdown">
            @foreach($locales as $code => $locale)
                <a class="dropdown-item language-option {{ $currentLocale === $code ? 'active' : '' }}"
                   href="#"
                   data-lang="{{ $code }}"
                   onclick="switchLanguage('{{ $code }}'); return false;">
                    <span class="me-2">{{ $locale['flag'] }}</span>
                    {{ $locale['name'] }}
                    @if($currentLocale === $code)
                        <i class="feather-check ms-auto text-success"></i>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
@else
    {{-- Landing Page Style --}}
    <div class="language-selector-wrapper" style="position: relative; display: inline-block;">
        <button class="language-toggle-btn" onclick="toggleLanguageDropdown()" style="
            background: transparent;
            border: 2px solid rgba(255,255,255,0.3);
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        ">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="2" y1="12" x2="22" y2="12"></line>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
            </svg>
            <span class="current-lang">{{ strtoupper($currentLocale) }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="dropdown-arrow">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>

        <div class="language-dropdown-landing" id="languageDropdown" style="
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            min-width: 200px;
            display: none;
            z-index: 1000;
            overflow: hidden;
        ">
            @foreach($locales as $code => $locale)
                <a href="#" class="language-option-landing {{ $currentLocale === $code ? 'active' : '' }}"
                   data-lang="{{ $code }}"
                   onclick="switchLanguage('{{ $code }}'); return false;"
                   style="
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                    padding: 0.75rem 1rem;
                    color: #333;
                    text-decoration: none;
                    transition: background 0.2s;
                    border-bottom: 1px solid #f0f0f0;
                ">
                    <span style="font-size: 1.2rem;">{{ $locale['flag'] }}</span>
                    <span style="flex: 1;">{{ $locale['name'] }}</span>
                    @if($currentLocale === $code)
                        <span style="color: #28a745; font-weight: bold;">✓</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    <style>
        .language-toggle-btn:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.5);
        }

        .language-option-landing:hover {
            background: #f8f9fa;
        }

        .language-option-landing.active {
            background: #e8f5e9;
        }

        .language-option-landing:last-child {
            border-bottom: none;
        }

        @media (max-width: 768px) {
            .current-lang {
                display: inline;
            }

            .language-dropdown-landing {
                right: 0;
                min-width: 180px;
            }
        }
    </style>

    <script>
        function toggleLanguageDropdown() {
            const dropdown = document.getElementById('languageDropdown');
            dropdown.style.display = dropdown.style.display === 'none' || dropdown.style.display === '' ? 'block' : 'none';
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const selector = event.target.closest('.language-selector-wrapper');
            if (!selector) {
                const dropdown = document.getElementById('languageDropdown');
                if (dropdown) {
                    dropdown.style.display = 'none';
                }
            }
        });
    </script>
@endif

<script>
    function switchLanguage(locale) {
        // Show loading state (optional)
        const currentLangSpan = document.querySelector('.current-lang');
        if (currentLangSpan) {
            currentLangSpan.textContent = '...';
        }

        // Send POST request to switch language
        fetch(`/language/switch/${locale}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to apply new language
                window.location.reload();
            } else {
                console.error('Failed to switch language:', data.message);
                alert('Failed to switch language. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error switching language:', error);
            alert('An error occurred. Please try again.');
        });
    }
</script>
