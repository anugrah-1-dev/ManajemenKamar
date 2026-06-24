<li class="nav-item dropdown user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}"
             class="user-image img-circle elevation-2" alt="User Image">
        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
    </a>

    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        {{-- User Header --}}
        <li class="user-header bg-primary">
            <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}"
                 class="img-circle elevation-2" alt="User Image">
            <p>
                {{ Auth::user()->name }}
                <small>Member since {{ Auth::user()->created_at->format('M Y') }}</small>
            </p>
        </li>

        {{-- TOGGLE DARK MODE --}}
        <li class="dropdown-item d-flex justify-content-between align-items-center">
            <span>Dark Mode</span>
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" id="themeToggle">
            </div>
        </li>

        {{-- User Footer --}}
        <li class="user-footer">
            <a href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="btn btn-default btn-flat float-right">
                <i class="fas fa-sign-out-alt text-danger"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
        @include('adminlte::partials.navbar.dropdown-user-menu')

    </ul>
</li>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('themeToggle');
        const body = document.body;
        const sidebar = document.querySelector('.main-sidebar');

        function applyTheme(theme) {
            if (theme === 'dark') {
                body.classList.add('bg-dark', 'text-white');
                sidebar?.classList.remove('sidebar-dark-primary');
                sidebar?.classList.add('sidebar-light');
            } else {
                body.classList.remove('bg-dark', 'text-white');
                sidebar?.classList.remove('sidebar-light');
                sidebar?.classList.add('sidebar-dark-primary');
            }
        }

        const savedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(savedTheme);
        if (toggle) toggle.checked = savedTheme === 'dark';

        if (toggle) {
            toggle.addEventListener('change', function () {
                const theme = this.checked ? 'dark' : 'light';
                localStorage.setItem('theme', theme);
                applyTheme(theme);
            });
        }
    });
</script>
