/**
 * Main JS
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        console.log('Anthome Theme Init');

        // --- Mega Menu Logic ---
        // Initialize Bootstrap Tabs in Mega Menu on hover
        var triggerTabList = [].slice.call(document.querySelectorAll('.megamenu-nav .nav-link'));
        triggerTabList.forEach(function (triggerEl) {
            triggerEl.addEventListener('mouseenter', function (event) {
                var tabTrigger = new bootstrap.Tab(triggerEl);
                tabTrigger.show();
            });
        });

        // Mobile Menu Dropdown Toggle
        var shopDropdown = document.getElementById('shopDropdown');
        var megamenu = document.querySelector('.dropdown.has-megamenu .dropdown-menu.megamenu');
        var dropdownParent = document.querySelector('.dropdown.has-megamenu');
        
        if (shopDropdown && megamenu && dropdownParent) {
            shopDropdown.addEventListener('click', function(e) {
                if (window.innerWidth < 992) {
                    // Bootstrap handles the toggle via data-bs-toggle, 
                    // but we ensure it works correctly here if needed.
                }
            });

            // Close menu when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 992) {
                    if (!dropdownParent.contains(e.target)) {
                        megamenu.classList.remove('show');
                        shopDropdown.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        }

        // --- Countdown Timer Logic ---
        function startCountdown() {
            var countdownElement = document.getElementById("countdown-timer");
            if (!countdownElement) return;

            // Set countdown to 2 days from now
            let countDownDate = new Date().getTime() + (2 * 24 * 60 * 60 * 1000);

            let x = setInterval(function() {
                let now = new Date().getTime();
                let distance = countDownDate - now;

                let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                var elDays = document.getElementById("days");
                var elHours = document.getElementById("hours");
                var elMinutes = document.getElementById("minutes");
                var elSeconds = document.getElementById("seconds");

                if (elDays) elDays.innerHTML = days < 10 ? "0" + days : days;
                if (elHours) elHours.innerHTML = hours < 10 ? "0" + hours : hours;
                if (elMinutes) elMinutes.innerHTML = minutes < 10 ? "0" + minutes : minutes;
                if (elSeconds) elSeconds.innerHTML = seconds < 10 ? "0" + seconds : seconds;

                if (distance < 0) {
                    clearInterval(x);
                    countdownElement.innerHTML = "EXPIRED";
                }
            }, 1000);
        }
        
        startCountdown();

    });

})(jQuery);
