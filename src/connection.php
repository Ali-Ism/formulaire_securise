<?php
include '../logs/secure.php';
include '../config/config.php'; 

// Démarrer la session
session_start();

// Fonction pour enregistrer les logs des tentatives de connexion
function log_attempt($email, $status) {
    $log_file = '../logs/login_attempts.log'; // Chemin du fichier log
    $date = date('Y-m-d H:i:s'); // Date et heure de la tentative
    $ip_address = $_SERVER['REMOTE_ADDR']; // Adresse IP de l'utilisateur
    $log_entry = "$date | Email: $email | Status: $status | IP: $ip_address\n";

    // Écrire la ligne dans le fichier log
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

// Vérification de l'envoi du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie que les champs existent
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        echo "Champs manquants.";
        exit;
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prépare la requête SQL
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Sécurise la session en régénérant l'ID
        session_regenerate_id(true); // Nouveau session ID

        // Authentification réussie
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email']
        ];

        // Enregistrer la tentative de connexion réussie dans le fichier log
        log_attempt($email, 'Réussi');

        // Rediriger vers la page sécurisée
        header('Location: ../public/index.html'); 
        exit;
    } else {
        // Enregistrer la tentative de connexion échouée dans le fichier log
        log_attempt($email, 'Échoué');
        
        echo "❌ Email ou mot de passe incorrect.";
    }
}
?>
