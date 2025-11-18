🚀 Lancement du projet TravelTime (macOS)

1 – Ouvrir le projet dans le terminal
        - Ouvrez le dossier TravelTime de l’une des manières suivantes :
            Méthode 1 : Faites un clic droit sur le dossier → "Ouvrir avec Visual Studio Code"
            Méthode 2 : Cliquez sur le dossier tout en maintenant Ctrl, puis "Ouvrir dans le Terminal"
            Méthode 3 :Appuyez sur Cmd + Espace, tapez "Terminal" et validez

        - Naviguez jusqu’au dossier : cd /chemin/vers/TravelTime

2 – Lancer le script lancer_traveltime.sh
        - Depuis VS Code ou le Terminal :
            chmod +x lancer_traveltime.sh
            ./lancer_traveltime.sh
            🛠️ Le premier commande rend le script exécutable, la deuxième le lance.

3 – Confirmation de démarrage
        - Si tout se passe bien, vous verrez un message comme :
        ✅ Serveur lancé avec succès (PID 61581) sur http://localhost:9091

4 – Arrêter le serveur
        - Appuyez sur Ctrl + C dans le terminal pour arrêter le script en cours

        - lsof -i :9091 deamnde le PID

        - Si besoin, terminez le processus manuellement avec :
            kill 61581

        - Remplacez 61581 par le PID affiché dans votre terminal.