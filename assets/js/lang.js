// Language switcher functionality
;(() => {
  // Declare translations variable
  let translations

  // Get current language from localStorage or default to French
  let currentLang = localStorage.getItem("preferredLanguage") || "fr"

  // Function to set language
  function setLanguage(lang) {
    currentLang = lang
    localStorage.setItem("preferredLanguage", lang)
    updatePageContent()
    updateLanguageSelector()

    // Update HTML lang attribute
    document.documentElement.lang = lang
  }

  // Function to update all translatable elements
  function updatePageContent() {
    if (!translations || !translations[currentLang]) {
      console.error("Translations not loaded or language not found")
      return
    }

    const elements = document.querySelectorAll("[data-i18n]")
    elements.forEach((element) => {
      const key = element.getAttribute("data-i18n")
      if (translations[currentLang][key]) {
        // Check if it's an input placeholder
        if (element.tagName === "INPUT" && element.hasAttribute("placeholder")) {
          element.placeholder = translations[currentLang][key]
        } else {
          element.textContent = translations[currentLang][key]
        }
      }
    })
  }

  // Function to update language selector active state
  function updateLanguageSelector() {
    const langButtons = document.querySelectorAll(".lang-option")
    langButtons.forEach((button) => {
      if (button.getAttribute("data-lang") === currentLang) {
        button.classList.add("active")
      } else {
        button.classList.remove("active")
      }
    })

    // Update the displayed language in the dropdown
    const currentLangDisplay = document.querySelector(".current-lang")
    if (currentLangDisplay) {
      const langNames = {
        fr: "FR",
        en: "EN",
        mg: "MG",
      }
      currentLangDisplay.textContent = langNames[currentLang] || "FR"
    }
  }

  // Initialize language on page load
  function init() {
    // Wait for translations to be loaded
    if (typeof translations === "undefined") {
      console.error("Translations not loaded. Make sure translations.js is included before lang.js")
      return
    }

    // Set initial language
    setLanguage(currentLang)

    // Add click event listeners to language buttons
    const langButtons = document.querySelectorAll(".lang-option")
    langButtons.forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault()
        const lang = this.getAttribute("data-lang")
        setLanguage(lang)

        // Close dropdown after selection
        const dropdown = document.querySelector(".language-dropdown")
        if (dropdown) {
          dropdown.classList.remove("show")
        }
      })
    })

    // Toggle dropdown
    const langToggle = document.querySelector(".language-selector")
    if (langToggle) {
      langToggle.addEventListener("click", (e) => {
        e.stopPropagation()
        const dropdown = document.querySelector(".language-dropdown")
        if (dropdown) {
          dropdown.classList.toggle("show")
        }
      })
    }

    // Close dropdown when clicking outside
    document.addEventListener("click", (e) => {
      const dropdown = document.querySelector(".language-dropdown")
      const langSelector = document.querySelector(".language-selector")

      if (dropdown && !langSelector.contains(e.target)) {
        dropdown.classList.remove("show")
      }
    })
  }

  // Run init when DOM is ready
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init)
  } else {
    init()
  }

  // Expose setLanguage function globally if needed
  window.setLanguage = setLanguage
})()