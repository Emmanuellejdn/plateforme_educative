<?php
session_start();
include 'connexionbase.php';

// Vérifier l'authentification
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit;
}

// Fonction pour ajouter un commentaire
function addComment($bdd, $utilisateur_id, $cours_id, $contenu) {
    try {
        $stmt = $bdd->prepare("INSERT INTO commentaire (utilisateur_id, cours_id, contenu) VALUES (?, ?, ?)");
        return $stmt->execute([$utilisateur_id, $cours_id, $contenu]);
    } catch (PDOException $e) {
        return false;
    }
}

// Fonction pour récupérer les commentaires d'un cours
function getComments($bdd, $cours_id) {
    try {
        $stmt = $bdd->prepare("
            SELECT c.id, c.contenu, c.date_commentaire, u.nom as auteur
            FROM commentaire c 
            JOIN utilisateur u ON c.utilisateur_id = u.id 
            WHERE c.cours_id = ? 
            ORDER BY c.date_commentaire DESC
        ");
        $stmt->execute([$cours_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// Fonction pour supprimer un commentaire
function deleteComment($bdd, $comment_id, $utilisateur_id) {
    try {
        $stmt = $bdd->prepare("DELETE FROM commentaire WHERE id = ? AND utilisateur_id = ?");
        return $stmt->execute([$comment_id, $utilisateur_id]);
    } catch (PDOException $e) {
        return false;
    }
}

// Fonction pour ajouter/retirer un like
function toggleLike($bdd, $utilisateur_id, $cours_id) {
    try {
        // Vérifier si l'utilisateur a déjà liké ce cours
        $stmt = $bdd->prepare("SELECT id FROM likes WHERE utilisateur_id = ? AND cours_id = ?");
        $stmt->execute([$utilisateur_id, $cours_id]);
        $existingLike = $stmt->fetch();
        
        if ($existingLike) {
            // Retirer le like
            $stmt = $bdd->prepare("DELETE FROM likes WHERE utilisateur_id = ? AND cours_id = ?");
            $stmt->execute([$utilisateur_id, $cours_id]);
            return ['action' => 'removed', 'liked' => false];
        } else {
            // Ajouter le like
            $stmt = $bdd->prepare("INSERT INTO likes (utilisateur_id, cours_id) VALUES (?, ?)");
            $stmt->execute([$utilisateur_id, $cours_id]);
            return ['action' => 'added', 'liked' => true];
        }
    } catch (PDOException $e) {
        return false;
    }
}

// Fonction pour obtenir le nombre de likes d'un cours
function getLikesCount($bdd, $cours_id) {
    try {
        $stmt = $bdd->prepare("SELECT COUNT(*) as count FROM likes WHERE cours_id = ?");
        $stmt->execute([$cours_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    } catch (PDOException $e) {
        return 0;
    }
}

// Fonction pour vérifier si l'utilisateur a liké un cours
function hasUserLiked($bdd, $utilisateur_id, $cours_id) {
    try {
        $stmt = $bdd->prepare("SELECT id FROM likes WHERE utilisateur_id = ? AND cours_id = ?");
        $stmt->execute([$utilisateur_id, $cours_id]);
        return $stmt->fetch() !== false;
    } catch (PDOException $e) {
        return false;
    }
}

// Traitement des requêtes AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $utilisateur_id = $_SESSION['id'] ?? null;
    
    if (!$utilisateur_id) {
        echo json_encode(['success' => false, 'message' => 'Utilisateur non identifié']);
        exit;
    }
    
    switch ($action) {
        case 'add_comment':
            $cours_id = $_POST['cours_id'] ?? '';
            $contenu = trim($_POST['contenu'] ?? '');
            
            if (!$cours_id || !$contenu) {
                echo json_encode(['success' => false, 'message' => 'Cours et contenu requis']);
                exit;
            }
            
            if (addComment($bdd, $utilisateur_id, $cours_id, $contenu)) {
                $comments = getComments($bdd, $cours_id);
                echo json_encode([
                    'success' => true, 
                    'message' => 'Commentaire ajouté avec succès',
                    'comments' => $comments
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout du commentaire']);
            }
            exit;
            
        case 'delete_comment':
            $comment_id = $_POST['comment_id'] ?? '';
            
            if (!$comment_id) {
                echo json_encode(['success' => false, 'message' => 'ID du commentaire requis']);
                exit;
            }
            
            if (deleteComment($bdd, $comment_id, $utilisateur_id)) {
                echo json_encode(['success' => true, 'message' => 'Commentaire supprimé']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
            }
            exit;
            
        case 'toggle_like':
            $cours_id = $_POST['cours_id'] ?? '';
            
            if (!$cours_id) {
                echo json_encode(['success' => false, 'message' => 'ID du cours requis']);
                exit;
            }
            
            $result = toggleLike($bdd, $utilisateur_id, $cours_id);
            if ($result) {
                $likesCount = getLikesCount($bdd, $cours_id);
                echo json_encode([
                    'success' => true,
                    'action' => $result['action'],
                    'liked' => $result['liked'],
                    'likes_count' => $likesCount
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors du traitement du like']);
            }
            exit;
            
        case 'get_comments':
            $cours_id = $_POST['cours_id'] ?? '';
            
            if (!$cours_id) {
                echo json_encode(['success' => false, 'message' => 'ID du cours requis']);
                exit;
            }
            
            $comments = getComments($bdd, $cours_id);
            echo json_encode(['success' => true, 'comments' => $comments]);
            exit;
            
        case 'get_course_stats':
            $cours_id = $_POST['cours_id'] ?? '';
            
            if (!$cours_id) {
                echo json_encode(['success' => false, 'message' => 'ID du cours requis']);
                exit;
            }
            
            $likesCount = getLikesCount($bdd, $cours_id);
            $userLiked = hasUserLiked($bdd, $utilisateur_id, $cours_id);
            $comments = getComments($bdd, $cours_id);
            
            echo json_encode([
                'success' => true,
                'likes_count' => $likesCount,
                'user_liked' => $userLiked,
                'comments' => $comments
            ]);
            exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Action non reconnue']);
?>
