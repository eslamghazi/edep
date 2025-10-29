<style>
    .language-switcher {
        position: absolute;
        top: 20px;
        {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 20px;
        z-index: 1000;
    }
    .language-switcher .btn {
        min-width: 80px;
        border-radius: 25px;
        font-weight: bold;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
</style>

<!-- Language Switcher -->
<div class="language-switcher">
    @if(app()->getLocale() == 'ar')
        <a href="{{ route('lang.switch', 'en') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-globe"></i> English
        </a>
    @else
        <a href="{{ route('lang.switch', 'ar') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-globe"></i> عربي
        </a>
    @endif
</div>
