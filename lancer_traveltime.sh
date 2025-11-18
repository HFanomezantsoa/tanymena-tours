#!/bin/bash
# Script pour lancer le projet TravelTime sur macOS (port 9091)

# Aller dans le dossier du projet (modifier si besoin)
cd ~/Downloads/TravelTime || { echo "❌ Dossier Grandoria introuvable dans ~/Downloads"; exit 1; }

# Vérifier si le port 9091 est déjà utilisé
if lsof -i :9091 >/dev/null; then
    echo "⚠️ Port 9091 déjà utilisé. Veuillez fermer le processus qui l'occupe ou choisir un autre port."
    exit 1
fi

# Lancer un serveur local sur le port 9090 en arrière-plan
python3 -m http.server 9091 &

# Récupérer le PID du serveur lancé
PID=$!

# Attendre 2 secondes le temps que le serveur démarre
sleep 2

# Ouvrir le navigateur sur l'URL
open http://localhost:9091

echo "✅ Serveur lancé avec succès (PID $PID) sur http://localhost:9091"
echo "Pour arrêter le serveur : kill $PID"