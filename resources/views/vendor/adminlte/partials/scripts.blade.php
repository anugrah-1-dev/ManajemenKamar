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
