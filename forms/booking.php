<?php
// Activer l'affichage des erreurs pour debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuration de la base de données
$dbPath = __DIR__ . '/../admin/var/data.db';

try {
    // Connexion à la base de données SQLite
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Récupération sécurisée des données POST
    $tourPackage = $_POST['tour_package'] ?? '';
    $departureDate = $_POST['departure_date'] ?? null;
    $returnDate = $_POST['return_date'] ?? null;
    $adults = (int)($_POST['adults'] ?? 1);
    $children = (int)($_POST['children'] ?? 0);
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $nationality = $_POST['nationality'] ?? '';
    $passport = $_POST['passport'] ?? '';
    $specialRequests = $_POST['special_requests'] ?? '';
    
    // Validation basique
    if (empty($tourPackage) || empty($firstName) || empty($lastName) || empty($email)) {
        throw new Exception('Veuillez remplir tous les champs obligatoires.');
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Adresse email invalide.');
    }
    
    // Préparation de la requête d'insertion
    $sql = "INSERT INTO bookings (
        tour_name, client_name, client_email, client_phone, 
        departure_date, return_date, adults, children, 
        nationality, passport, special_requests, status, created_at
    ) VALUES (
        :tour_name, :client_name, :client_email, :client_phone,
        :departure_date, :return_date, :adults, :children,
        :nationality, :passport, :special_requests, :status, :created_at
    )";
    
    $stmt = $pdo->prepare($sql);
    
    // Exécution de la requête
    $result = $stmt->execute([
        ':tour_name' => $tourPackage,
        ':client_name' => $firstName . ' ' . $lastName,
        ':client_email' => $email,
        ':client_phone' => $phone,
        ':departure_date' => $departureDate ? date('Y-m-d', strtotime($departureDate)) : null,
        ':return_date' => $returnDate ? date('Y-m-d', strtotime($returnDate)) : null,
        ':adults' => $adults,
        ':children' => $children,
        ':nationality' => $nationality,
        ':passport' => $passport,
        ':special_requests' => $specialRequests,
        ':status' => 'nouveau',
        ':created_at' => date('Y-m-d H:i:s')
    ]);
    
    if ($result) {
        $bookingId = $pdo->lastInsertId();
        
        // Envoi d'email de confirmation (optionnel)
        $subject = "Confirmation de votre demande de réservation - Tany Mena Tours";
        $message = "
        Bonjour $firstName $lastName,
        
        Nous avons bien reçu votre demande de réservation pour le tour '$tourPackage'.
        
        Numéro de réservation: #$bookingId
        
        Notre équipe va traiter votre demande dans les plus brefs délais et vous recontacter.
        
        Cordialement,
        L'équipe Tany Mena Tours
        ";
        
        $headers = "From: tanymenatours97@gmail.com\r\n";
        $headers .= "Reply-To: tanymenatours97@gmail.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        mail($email, $subject, $message, $headers);
        
        // Réponse de succès
        echo json_encode([
            'success' => true,
            'message' => 'Votre demande de réservation a été enregistrée avec succès. Numéro de réservation: #' . $bookingId,
            'booking_id' => $bookingId
        ]);
    } else {
        throw new Exception('Erreur lors de l\'enregistrement de la réservation.');
    }
    
} catch (Exception $e) {
    // Réponse d'erreur
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
