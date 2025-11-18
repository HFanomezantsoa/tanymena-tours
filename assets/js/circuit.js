// Récupérer le paramètre "circuit" dans l'URL
  const params = new URLSearchParams(window.location.search);
  const circuit = params.get("circuit");

  // Masquer tous les circuits
  document.querySelectorAll(".circuit-section").forEach(el => {
    el.style.display = "none";
  });

  // Afficher seulement le circuit demandé
  if (circuit) {
    const section = document.getElementById("circuit-" + circuit);
    if (section) {
      section.style.display = "block";
    }
  }