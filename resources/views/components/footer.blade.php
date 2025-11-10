<footer class="footer">
    <div class="footer-content">
        <!-- Logo dan Teks DigiLib -->
        <div class="logo-container">
            <img src="{{ asset('img/digilib2.svg') }}" alt="DigiLib Logo" />
            {{-- <span>DigiLib</span> --}}
        </div>

        <!-- Navigasi Menu -->
        <div class="nav-links">
            <a href="{{ route('dashboard') }}"
                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Home</a>
            <div class="divider">|</div>
            <div class="nav-link">Book</div>
            <div class="divider">|</div>
            <div class="nav-link">About Us</div>
            <div class="divider">|</div>
            <div class="nav-link">Contact Us</div>
        </div>

        <!-- Copyright -->
        <p>&copy; 2025 DigiLib. All rights reserved.</p>
    </div>
</footer>