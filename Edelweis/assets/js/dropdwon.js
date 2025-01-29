document.addEventListener("DOMContentLoaded", function () {
    var dropdowns = document.querySelectorAll('.nav-item.dropdown');

    dropdowns.forEach(function (dropdown) {
        dropdown.addEventListener('mouseenter', function () {
            var menu = dropdown.querySelector('.dropdown-menu');
            if (menu) {
                menu.classList.add('show');
            }
        });

        dropdown.addEventListener('mouseleave', function () {
            var menu = dropdown.querySelector('.dropdown-menu');
            if (menu) {
                menu.classList.remove('show');
            }
        });
    });
});
