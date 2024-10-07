// Show hide functionality taken from reveal.js
// Converted from jQuery to vanilla JavaScript

// Function to handle slideUp animation
function slideUp(element, duration = 1000, easing = 'ease', callback) {
    element.style.transition = `height ${duration}ms ${easing}, padding ${duration}ms ${easing}, margin ${duration}ms ${easing}`;
    element.style.boxSizing = 'border-box';
    element.style.height = `${element.offsetHeight}px`;
    element.offsetHeight; // Force repaint
  
    requestAnimationFrame(() => {
      element.style.height = '0';
      element.style.paddingTop = '0';
      element.style.paddingBottom = '0';
      element.style.marginTop = '0';
      element.style.marginBottom = '0';
    });
  
    setTimeout(() => {
      element.style.display = 'none';
      element.style.removeProperty('height');
      element.style.removeProperty('padding-top');
      element.style.removeProperty('padding-bottom');
      element.style.removeProperty('margin-top');
      element.style.removeProperty('margin-bottom');
      element.style.removeProperty('transition');
      if (typeof callback === 'function') callback();
    }, duration);
}
  
// Function to handle slideDown animation
function slideDown(element, duration = 1000, easing = 'ease', callback) {
    element.style.removeProperty('display');
    let display = window.getComputedStyle(element).display;

    if (display === 'none') display = 'block';
    element.style.display = display;
    let height = element.offsetHeight;
    element.style.height = '0';
    element.style.paddingTop = '0';
    element.style.paddingBottom = '0';
    element.style.marginTop = '0';
    element.style.marginBottom = '0';
    element.offsetHeight; // Force repaint

    element.style.boxSizing = 'border-box';
    element.style.transition = `height ${duration}ms ${easing}, padding ${duration}ms ${easing}, margin ${duration}ms ${easing}`;

    requestAnimationFrame(() => {
    element.style.height = `${height}px`;
    element.style.removeProperty('padding-top');
    element.style.removeProperty('padding-bottom');
    element.style.removeProperty('margin-top');
    element.style.removeProperty('margin-bottom');
    });

    setTimeout(() => {
    element.style.removeProperty('height');
    element.style.removeProperty('transition');
    if (typeof callback === 'function') callback();
    }, duration);
}
  
// Function to toggle slideUp and slideDown
function slideToggle(element, duration = 1000, easing = 'ease', callback) {
    if (window.getComputedStyle(element).display === 'none') {
    slideDown(element, duration, easing, callback);
    } else {
    slideUp(element, duration, easing, callback);
    }
}
  
// Function to check if an element is visible
function isVisible(element) {
    return window.getComputedStyle(element).display !== 'none';
}

// Main showHide function
function showHide(elements, options) {
    // Default options
    const defaults = {
        speed: 1000,
        easing: 'ease',
        changeText: 0,
        showText: 'Show',
        hideText: 'Hide',
    };

    // Merge defaults with user options
    const settings = { ...defaults, ...options };

    // Convert NodeList to Array if necessary
    if (!Array.isArray(elements)) {
        elements = Array.from(elements);
    }

    elements.forEach((element) => {
        // First click event
        element.addEventListener('click', function () {
            element.classList.toggle('open');
            element.parentNode.classList.toggle('show');
        });

        // Second click event
        element.addEventListener('click', function (event) {
            event.preventDefault();

            // Optionally close all elements with the class 'toggle-div'
            const toggleDivs = document.querySelectorAll('.toggle-div');
            toggleDivs.forEach((div) => {
                slideUp(div, settings.speed, settings.easing);
            });

            // Store the clicked element
            const toggleClick = element;

            // Get the target div from the 'rel' attribute
            const toggleDivSelector = element.getAttribute('rel');
            const toggleDiv = document.querySelector(toggleDivSelector);

            if (toggleDiv) {
                // Trigger custom 'faq:start' event
                const startEvent = new Event('faq:start');
                toggleDiv.dispatchEvent(startEvent);

                // Toggle the visibility of the target div
                slideToggle(toggleDiv, settings.speed, settings.easing, function () {
                    // Trigger custom 'faq:complete' event after animation
                    const completeEvent = new Event('faq:complete');
                    toggleDiv.dispatchEvent(completeEvent);

                    // Optionally change the button text
                    if (settings.changeText === 1) {
                        if (isVisible(toggleDiv)) {
                            toggleClick.textContent = settings.hideText;
                        } else {
                            toggleClick.textContent = settings.showText;
                        }
                    }
                });
            }

            return false;
        });
    });
}
  
// Function to get URL parameters
function getGETvariable(key) {
    const params = new URLSearchParams(window.location.search);
    if (key !== undefined) {
    return params.get(key) || false;
    } else {
    const getObj = {};
    for (const [k, v] of params.entries()) {
        getObj[k] = v;
    }
    return getObj;
    }
}

// Initialize showHide on elements with the class 'show-hide'
document.addEventListener('DOMContentLoaded', () => {
    const showHideElements = document.querySelectorAll('.show-hide');
    showHide(showHideElements, {
        speed: 250,    // Speed of the toggle animation
        easing: 'ease', // Easing effect
        changeText: 0, // Set to 1 if you want to change button text
    });

    // Custom event listener for 'faq:start'
    const faqDivs = document.querySelectorAll('.rbd-faq-sliding-div');
    faqDivs.forEach((div) => {
        div.addEventListener('faq:start', function () {
            if (div.previousElementSibling && div.previousElementSibling.classList.contains('open')) {
            // Triggered when the element is open
            } else {
            // Triggered when the element is closed
            }
        });
    });

    // Handle scrolling to a specific question on page load
    window.addEventListener('load', function () {
        const targetQuestion = getGETvariable('targetQuestion');
        if (typeof targetQuestion === 'string') {
            const targetElement = document.querySelector(`#rbd-faq-question-${targetQuestion}`);
            if (targetElement) {
                const scrollTo = targetElement.getBoundingClientRect().top + window.scrollY - window.innerHeight / 10;
                setTimeout(() => {
                    window.scrollTo({ top: scrollTo, behavior: 'smooth' });
                }, 10);
            }
        }
    });
});