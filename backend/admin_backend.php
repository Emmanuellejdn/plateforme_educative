<?php
session_start();
include 'connexionbase.php';

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: ../interfaces/connexion.php');
    exit;
}

// Vérifier le rôle admin (optionnel, selon votre logique d'authentification)
// Vous pouvez ajouter cette vérification si nécessaire

// Fonction pour récupérer tous les utilisateurs
function getAllUsers($bdd) {
    $stmt = $bdd->prepare("SELECT id, nom, email, role, date_creation FROM utilisateur ORDER BY date_creation DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer tous les cours
function getAllCourses($bdd, $langue = null) {
    if ($langue) {
        $stmt = $bdd->prepare("SELECT id, titre, description, langues, video_url, niveau, duree_minutes, date_creation FROM cours WHERE langues = ? ORDER BY date_creation DESC");
        $stmt->execute([$langue]);
    } else {
        $stmt = $bdd->prepare("SELECT id, titre, description, langues, video_url, niveau, duree_minutes, date_creation FROM cours ORDER BY date_creation DESC");
        $stmt->execute();
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour ajouter un cours
function addCourse($bdd, $titre, $description, $langue, $video_url = '', $niveau = 'debutant', $duree = 0) {
    $stmt = $bdd->prepare("INSERT INTO cours (titre, description, langues, video_url, niveau, duree_minutes) VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$titre, $description, $langue, $video_url, $niveau, $duree]);
}

// Fonction pour supprimer un utilisateur
function deleteUser($bdd, $userId) {
    $stmt = $bdd->prepare("DELETE FROM utilisateur WHERE id = ?");
    return $stmt->execute([$userId]);
}

// Fonction pour supprimer un cours
function deleteCourse($bdd, $courseId) {
    $stmt = $bdd->prepare("DELETE FROM cours WHERE id = ?");
    return $stmt->execute([$courseId]);
}

// Fonction pour obtenir les statistiques
function getStats($bdd) {
    $stats = [];
    
    // Nombre de cours par langue
    $stmt = $bdd->prepare("SELECT langues, COUNT(*) as nombre FROM cours GROUP BY langues");
    $stmt->execute();
    $stats['cours_par_langue'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Nombre total d'utilisateurs
    $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM utilisateur WHERE role = 'eleve'");
    $stmt->execute();
    $stats['total_eleves'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Nombre total de cours
    $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM cours");
    $stmt->execute();
    $stats['total_cours'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    return $stats;
}

// Traitement des actions AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'add_course':
            $titre = $_POST['titre'] ?? '';
            $description = $_POST['description'] ?? '';
            $langue = $_POST['langue'] ?? '';
            $niveau = $_POST['niveau'] ?? 'debutant';
            $duree = $_POST['duree'] ?? 0;
            $video_url = $_POST['video_url'] ?? '';
            
            if ($titre && $langue) {
                if (addCourse($bdd, $titre, $description, $langue, $video_url, $niveau, $duree)) {
                    echo json_encode(['success' => true, 'message' => 'Cours ajouté avec succès']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout du cours']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Titre et langue requis']);
            }
            exit;
            
        case 'delete_user':
            $userId = $_POST['user_id'] ?? '';
            if ($userId && deleteUser($bdd, $userId)) {
                echo json_encode(['success' => true, 'message' => 'Utilisateur supprimé']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
            }
            exit;
            
        case 'delete_course':
            $courseId = $_POST['course_id'] ?? '';
            if ($courseId && deleteCourse($bdd, $courseId)) {
                echo json_encode(['success' => true, 'message' => 'Cours supprimé']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
            }
            exit;
            
        case 'get_courses':
            $langue = $_POST['langue'] ?? null;
            $courses = getAllCourses($bdd, $langue);
            echo json_encode(['success' => true, 'courses' => $courses]);
            exit;
    }
}

// Récupérer les données pour l'affichage
$users = getAllUsers($bdd);
$courses = getAllCourses($bdd);
$stats = getStats($bdd);
?>
