/**
 * File navigation.js.
 *
 * Handles navigation's behaviour (Open/Close).
 * Traps TAB inside navigation.
 * Moves naviagtion's place in DOM depending on window width.
 */
let midday_openCloseMenu = {};
midday_openCloseMenu.App = (function () {
    const navButton = document.getElementById('menu-button');
    const navMenu = document.querySelector('#main-nav');
    const navLinks = navMenu.querySelectorAll("li a");
    let lastNavLink = navMenu.lastElementChild.lastElementChild.firstElementChild;
    let beforeLastNavLink = lastNavLink.parentElement.previousElementSibling.firstElementChild;
    const closeButton = document.getElementById('close-button');
    let mql = window.matchMedia('(min-width: 1024px)');


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

    /* Listen to window width and change navMenu width accordingly. */
	mql.addEventListener("change", (e) => {
		if (document.body.classList.contains('active')) {
			if (e.matches) {
				/* the viewport is 1024 pixels or more */
				navMenu.style.width = "60%";
			} else {
				/* the viewport is 1023 pixels or less */
				navMenu.style.width = "100%";
			}
		} else {
			disableNavLinks();
			navMenu.style.width = "0%";
		}
	});

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
        /**
		 * For accessibility to work, we have to hide navMenu.
		 * To focus on closeButton after it becomes visible,
		 * we use a setTimeout() function to run the focus() method
		 * after 100 ms of clicking on navButton.
		 */
		setTimeout(function () {
			closeButton.focus();
		}, 100);
        navButton.setAttribute('aria-label', 'Menu expanded');
        navMenu.removeAttribute('aria-hidden');
        navMenu.style.visibility = "visible";
        navLinks.forEach(function (link) {
            link.removeAttribute('tabIndex');
        });
    }

    function disableNavLinks() {
        navButton.setAttribute('aria-label', 'Menu collapsed');
        navMenu.setAttribute('aria-hidden', 'true');
        navMenu.style.visibility = "hidden";
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
    new midday_openCloseMenu.App.init();
});

/** Move naviagtion depending on window width */
let newMQL = window.matchMedia('(min-width: 1024px)');
let insertedNode = document.getElementById('nav');
let originalParent = document.querySelector('div.sidebar');
let parentNode = document.getElementById('page');
let originalReference = document.querySelector('div.site-branding')
let referenceNode = document.getElementById('masthead');

if (window.matchMedia('screen and (max-width: 1023.5px)').matches) {
	parentNode.insertBefore(insertedNode, referenceNode);
}

newMQL.addEventListener("change", (e) => {
	if (!e.matches) {
		/* the viewport is 1023 pixels or less */
		parentNode.insertBefore(insertedNode, referenceNode);
	} else {
		/* the viewport is 1024 pixels or more */
		originalParent.insertBefore(insertedNode, originalReference.nextSibling);
	}
});
