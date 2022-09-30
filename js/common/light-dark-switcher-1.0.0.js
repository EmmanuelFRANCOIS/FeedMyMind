/**
 * ════════════════════════════════════════════════════════════════════════════
 *  Light & Dark Mode Switcher v1.0.0
 * ════════════════════════════════════════════════════════════════════════════
 *  Allow user to switch between color light & dark mode
 * ────────────────────────────────────────────────────────────────────────────
 *  Copyright © 2022 EmmanuelFRANCOIS. Tous droits réservés.
 * ────────────────────────────────────────────────────────────────────────────
 *  Inspired from [https://github.com/coliff/dark-mode-switch]
 * ════════════════════════════════════════════════════════════════════════════
 */

// Get Dark mode Switcher
var darkModeSwitcher = document.getElementById("lightDarkSwitcher");

// When document is loaded, setup Event listeners
window.addEventListener("load", function () {

  // Dark Mode event listener
  if (darkModeSwitcher) {
    darkModeSwitcher.addEventListener("click", function () {
      console.log('data-themeMode', $('body').attr('data-themeMode'));
      setDarkMode();
    });
  }

});

/**
 * Summary: function that adds or removes the attribute 'data-theme' depending if
 * the switch is 'on' or 'off'.
 *
 * Description: initTheme is a function that uses localStorage from JavaScript DOM,
 * to store the value of the HTML switch. If the switch was already switched to
 * 'on' it will set an HTML attribute to the body named: 'data-theme' to a 'dark'
 * value. If it is the first time opening the page, or if the switch was off the
 * 'data-theme' attribute will not be set.
 * @return {void}
 */
function initDarkMode() {
  var darkModeSelected =
    localStorage.getItem("themeMode") !== null &&
    localStorage.getItem("themeMode") === "dark";
  if ( darkModeSelected ) {
    document.body.setAttribute("data-themeMode", "dark");
  } else {
    document.body.removeAttribute("data-themeMode");
  }
}

/**
 * Summary: resetTheme checks if the switch is 'on' or 'off' and if it is toggled
 * on it will set the HTML attribute 'data-theme' to dark so the dark-theme CSS is
 * applied.
 * @return {void}
 */
function setDarkMode() {
  var darkSwitchIcon = document.getElementById("darkSwitchIcon");
  if ( localStorage.getItem("themeMode") !== null && localStorage.getItem("themeMode") === "dark" ) {
    // Remove dark mode
    document.body.removeAttribute("data-themeMode");
    localStorage.removeItem("themeMode");
    darkSwitchIcon.classList.replace('fa-sun','fa-moon')
  } else {  // Set dark mode
    document.body.setAttribute("data-themeMode", "dark");
    localStorage.setItem("themeMode", "dark");
    darkSwitchIcon.classList.replace('fa-moon','fa-sun')
  }
}
