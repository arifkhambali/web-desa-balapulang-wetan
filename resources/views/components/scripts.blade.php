<script>
    function initScripts() {
        // Dark Mode Logic
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;

        // Check local storage
        if (localStorage.theme === 'dark' || (!('theme' in localStorage))) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        if (themeToggle) {
            // Remove existing listeners to prevent duplicates
            const newThemeToggle = themeToggle.cloneNode(true);
            themeToggle.parentNode.replaceChild(newThemeToggle, themeToggle);

            newThemeToggle.addEventListener('click', () => {
                html.classList.toggle('dark');
                if (html.classList.contains('dark')) {
                    localStorage.theme = 'dark';
                } else {
                    localStorage.theme = 'light';
                }
            });
        }

        // Navbar Sticky Effect
        const navbar = document.getElementById('navbar');
        if (navbar) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('glass-nav', 'shadow-sm', 'py-2');
                    navbar.classList.remove('py-4');
                } else {
                    navbar.classList.remove('glass-nav', 'shadow-sm', 'py-2');
                    navbar.classList.add('py-4');
                }
            });
        }

        // Mobile Menu
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeMenuBtn = document.getElementById('close-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileLinks = document.querySelectorAll('.mobile-link');

        function toggleMenu() {
            if (mobileMenu) {
                mobileMenu.classList.toggle('translate-x-full');
            }
        }

        if (mobileMenuBtn) {
            // Clone to remove old listeners
            const newBtn = mobileMenuBtn.cloneNode(true);
            mobileMenuBtn.parentNode.replaceChild(newBtn, mobileMenuBtn);
            newBtn.addEventListener('click', toggleMenu);
        }

        if (closeMenuBtn) {
            const newCloseBtn = closeMenuBtn.cloneNode(true);
            closeMenuBtn.parentNode.replaceChild(newCloseBtn, closeMenuBtn);
            newCloseBtn.addEventListener('click', toggleMenu);
        }

        if (mobileLinks.length > 0) {
            mobileLinks.forEach(link => {
                // Clone to remove old listeners
                const newLink = link.cloneNode(true);
                link.parentNode.replaceChild(newLink, link);
                newLink.addEventListener('click', toggleMenu);
            });
        }
    }

    // Run on initial load
    initScripts();

    // Run on Livewire navigation
    document.addEventListener('livewire:navigated', () => {
        initScripts();
    });
</script>