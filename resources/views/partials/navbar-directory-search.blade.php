@once
@push('styles')
<style>
    /* Navbar directory search — single pill, no Bootstrap input-group quirks */
    .navbar-directory-search {
        margin-inline-start: 0.35rem;
    }
    @media (min-width: 992px) {
        .navbar-directory-search {
            margin-inline-start: 0.75rem;
            padding-inline-start: 0.75rem;
            border-inline-start: 1px solid rgba(255, 255, 255, 0.18);
        }
    }

    .navbar-directory-search__shell {
        display: flex;
        flex-direction: row;
        align-items: stretch;
        width: min(100%, 19rem);
        min-width: min(100%, 12rem);
        max-width: 19rem;
        background: #fff;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.35);
        box-shadow:
            0 1px 2px rgba(0, 0, 0, 0.12),
            0 4px 12px rgba(0, 0, 0, 0.18);
        overflow: hidden;
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }
    @media (max-width: 991.98px) {
        .navbar-directory-search__shell {
            width: 100%;
            max-width: none;
        }
    }

    .navbar-directory-search__shell:focus-within {
        border-color: rgba(125, 211, 252, 0.95);
        box-shadow:
            0 0 0 3px rgba(56, 189, 248, 0.35),
            0 4px 14px rgba(0, 0, 0, 0.2);
    }

    .navbar-directory-search.is-active .navbar-directory-search__shell {
        border-color: rgba(125, 211, 252, 0.85);
        box-shadow:
            0 0 0 2px rgba(56, 189, 248, 0.4),
            0 4px 14px rgba(0, 0, 0, 0.22);
    }

    .navbar-directory-search__input {
        flex: 1 1 auto;
        min-width: 0;
        width: 1%;
        box-sizing: border-box;
        appearance: none;
        -webkit-appearance: none;
        border: none !important;
        border-radius: 0 !important;
        background: transparent !important;
        color: #212529;
        font-family: inherit;
        font-size: 0.9375rem;
        line-height: 1.4;
        padding: 0.5rem 0.85rem;
        height: auto;
        min-height: 2.5rem;
        box-shadow: none !important;
    }

    .navbar-directory-search__input::placeholder {
        color: #868e96;
        opacity: 1;
    }

    .navbar-directory-search__input:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    .navbar-directory-search__input::-webkit-search-decoration,
    .navbar-directory-search__input::-webkit-search-cancel-button {
        -webkit-appearance: none;
        appearance: none;
    }

    .navbar-directory-search__btn {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.75rem;
        min-height: 2.5rem;
        margin: 0;
        padding: 0 !important;
        border: none !important;
        border-radius: 0 !important;
        appearance: none;
        -webkit-appearance: none;
        background: linear-gradient(180deg, #f1f5f9 0%, #e2e8f0 100%) !important;
        color: #0c4a6e !important;
        border-right: 1px solid rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease;
        line-height: 1;
    }

    .navbar-directory-search__btn:hover,
    .navbar-directory-search__btn:focus {
        background: linear-gradient(180deg, #e0f2fe 0%, #bae6fd 100%) !important;
        color: #075985 !important;
        outline: none !important;
    }

    .navbar-directory-search__btn:active {
        background: #bae6fd !important;
    }

    .navbar-directory-search__icon {
        display: block;
        font-size: 1.0625rem;
        line-height: 1;
        opacity: 0.95;
        -webkit-font-smoothing: antialiased;
    }
</style>
@endpush
@endonce
<li class="nav-item d-flex align-items-center my-2 my-lg-0 navbar-directory-search {{ Route::currentRouteNamed('search.*') ? 'is-active' : '' }}">
    <form class="w-100" method="get" action="{{ route('search.index') }}" role="search" aria-label="بحث باسم جامعة أو كلية في دليل الموقع">
        <div class="navbar-directory-search__shell" dir="rtl">
            <input
                type="search"
                name="q"
                value="{{ Route::currentRouteNamed('search.*') ? e(request('q', '')) : '' }}"
                class="navbar-directory-search__input"
                placeholder="جامعة أو كلية…"
                maxlength="120"
                autocomplete="off"
                aria-label="كلمة البحث"
                title="حرفين على الأقل للنتائج؛ أو اترك الحقل فاضي واضغط الزر لصفحة الشرح"
            >
            <button type="submit" class="navbar-directory-search__btn" aria-label="بحث في الدليل">
                <span class="fa fa-search navbar-directory-search__icon" aria-hidden="true"></span>
            </button>
        </div>
    </form>
</li>
