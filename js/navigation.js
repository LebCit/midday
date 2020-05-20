/**
 * File navigation.js.
 *
 * Handles navigation's behaviour (Open/Close).
 * Traps TAB inside navigation.
 */
let openCloseMenu = {};
openCloseMenu.App = (function () {
    const navButton = document.getElementById('menu-button');
    const navMenu = document.querySelector('#main-nav');
    const navLinks = navMenu.querySelectorAll("li a");
    let lastNavLink = navMenu.lastElementChild.lastElementChild.firstElementChild;
    let beforeLastNavLink = lastNavLink.parentElement.previousElementSibling.firstElementChild;
    const closeButton = document.getElementById('close-button');


    function initApp() {
        disableNavLinks();
    }

    function detectWidth(x) {
        if (x.matches) { // If media query matches
            navMenu.style.width = "60%";
        } else {
            navMenu.style.width = "100%";
        }
    }
    let x = window.matchMedia("(min-width: 1024px)");

    navButton.addEventListener('click', event => {
        event.preventDefault();
        document.body.classList.toggle('active');
        if (document.body.classList.contains('active')) {
            enableNavLinks();
            detectWidth(x); // Call listener function at run time
        } else {
            disableNavLinks();
            navMenu.style.width = "0%";
        }
    });

    navButton.addEventListener('keydown', event => {
        if ((document.body.classList.contains('active')) && (event.key === " " || event.key === "Enter" || event.key === "Spacebar" || event.key === "Esc" || event.key === "Escape")) {
            event.preventDefault();
            document.body.classList.remove('active');
            disableNavLinks();
            navMenu.style.width = "0%";
        } else if (event.key === " " || event.key === "Enter" || event.key === "Spacebar") {
            event.preventDefault();
            document.body.classList.add('active');
            enableNavLinks();
            detectWidth(x); // Call listener function at run time
        }
    });

    closeButton.addEventListener('click', event => {
        event.preventDefault();
        document.body.classList.remove('active');
        disableNavLinks();
        navMenu.style.width = "0%";
        navButton.focus();
    });

    closeButton.addEventListener('keydown', event => {
        if ((event.key === " " || event.key === "Enter" || event.key === "Spacebar" || event.key === "Esc" || event.key === "Escape")) {
            event.preventDefault();
            document.body.classList.remove('active');
            disableNavLinks();
            navMenu.style.width = "0%";
            navButton.focus();
        } else if (event.shiftKey && event.key === "Tab") {
            event.preventDefault();
            lastNavLink.focus();
        }
    });

    lastNavLink.addEventListener('keydown', event => {
        if (event.shiftKey && event.key === "Tab") {
            event.preventDefault();
            beforeLastNavLink.focus();
        } else if (event.key === "Tab") {
            event.preventDefault();
            closeButton.focus();
        }
    });

    function enableNavLinks() {
        navLinks[0].focus();
        navButton.setAttribute('aria-label', 'Menu expanded');
        navMenu.removeAttribute('aria-hidden');
        navLinks.forEach(function (link) {
            link.removeAttribute('tabIndex');
        });
    }

    function disableNavLinks() {
        navButton.setAttribute('aria-label', 'Menu collapsed');
        navMenu.setAttribute('aria-hidden', 'true');
        navLinks.forEach(function (link) {
            link.setAttribute('tabIndex', '-1');
        });
    }

    return {
        init: function () {
            initApp();
        }
    }
})();

window.addEventListener('DOMContentLoaded', (event) => {
    event.preventDefault();
    new openCloseMenu.App.init();
});
