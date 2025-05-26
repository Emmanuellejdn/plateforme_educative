<?php include '../backend/admin_backend.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Éducation Bilingue</title>
    <link rel="stylesheet" href="../css/admin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h1>Tableau de Bord - Administration</h1>
    </header>

    <nav>
        <ul>
            <li><a href="#utilisateurs">Liste des utilisateurs</a></li>
            <li><a href="#cours">Gestion des cours</a></li>
            <li><a href="#langues">Gestion des langues</a></li>
            <li><a href="#statistiques">Statistiques</a></li>
        </ul>
    </nav>

    <main>        <!-- Liste des utilisateurs -->
        <section id="utilisateurs">
            <h2>Liste des utilisateurs</h2>
            <table id="usersTable">
                <tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Date création</th><th>Action</th></tr>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['nom']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= $user['role'] ?></td>
                    <td><?= date('d/m/Y', strtotime($user['date_creation'])) ?></td>
                    <td><button class="delete" onclick="deleteUser(<?= $user['id'] ?>)">Supprimer</button></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>        <!-- Gestion des cours -->
        <section id="cours">
            <h2>Gestion des cours</h2>
            <label for="langue">Filtrer par langue :</label>
            <select id="langue">
                <option value="">Toutes les langues</option>
                <option value="fr">Français</option>
                <option value="en">Anglais</option>
                <option value="lng">Langues locales</option>
            </select>
            <button onclick="filtrerCours()">Voir les cours</button>

            <table id="coursesTable">
                <tr><th>ID</th><th>Titre</th><th>Langue</th><th>Niveau</th><th>Durée</th><th>Action</th></tr>
                <?php foreach($courses as $course): ?>
                <tr>
                    <td><?= $course['id'] ?></td>
                    <td><?= htmlspecialchars($course['titre']) ?></td>
                    <td><?= $course['langues'] ?></td>
                    <td><?= $course['niveau'] ?></td>
                    <td><?= $course['duree_minutes'] ?> min</td>
                    <td><button class="delete" onclick="deleteCourse(<?= $course['id'] ?>)">Supprimer</button></td>
                </tr>
                <?php endforeach; ?>
            </table>

            <button onclick="afficherFormulaireCours()">Ajouter un cours</button>            <form id="formAjoutCours" style="display:none;">
                <label for="nomCours">Titre du cours :</label>
                <input type="text" id="nomCours" required>
                
                <label for="descriptionCours">Description :</label>
                <textarea id="descriptionCours" rows="3"></textarea>
                
                <label for="langueSelectCours">Langue :</label>
                <select id="langueSelectCours" required>
                    <option value="fr">Français</option>
                    <option value="en">Anglais</option>
                    <option value="lng">Langues locales</option>
                </select>
                
                <label for="niveauCours">Niveau :</label>
                <select id="niveauCours">
                    <option value="debutant">Débutant</option>
                    <option value="intermediaire">Intermédiaire</option>
                    <option value="avance">Avancé</option>
                </select>
                
                <label for="dureeCours">Durée (minutes) :</label>
                <input type="number" id="dureeCours" min="0" value="0">
                
                <label for="videoUrl">URL de la vidéo :</label>
                <input type="text" id="videoUrl" placeholder="../images/video.mp4">
                
                <button type="button" onclick="ajouterCours()">Confirmer</button>
                <button type="button" onclick="annulerFormulaire()">Annuler</button>
            </form>
        </section>

        <!-- Gestion des langues -->
        <section id="langues">
            <h2>Gestion des langues</h2>
            <button onclick="afficherFormulaireLangue()">Ajouter une langue</button>
            <button onclick="afficherFormulaireSupprimerLangue()">Supprimer une langue</button>

            <form id="formAjoutLangue" style="display:none;">
                <label for="nomLangue">Nom de la langue :</label>
                <input type="text" id="nomLangue" required>
                <button type="submit">Confirmer</button>
            </form>

            <form id="formSupprimerLangue" style="display:none;">
                <label for="nomLangueSuppr">Nom de la langue :</label>
                <input type="text" id="nomLangueSuppr" required>
                <button type="submit">Confirmer</button>
            </form>
        </section>        <!-- Statistiques des leçons -->
        <section id="statistiques">
            <h2>Statistiques de la plateforme</h2>
            <div class="stats-container">
                <div class="stat-item">
                    <h3>Total des élèves</h3>
                    <p><?= $stats['total_eleves'] ?></p>
                </div>
                <div class="stat-item">
                    <h3>Total des cours</h3>
                    <p><?= $stats['total_cours'] ?></p>
                </div>
            </div>
            <p>Nombre de cours par langue :</p>
            <ul>
                <?php foreach($stats['cours_par_langue'] as $stat): ?>
                    <li>
                        <?php 
                        $langue_nom = '';
                        switch($stat['langues']) {
                            case 'fr': $langue_nom = 'Français'; break;
                            case 'en': $langue_nom = 'Anglais'; break;
                            case 'lng': $langue_nom = 'Langues locales'; break;
                            default: $langue_nom = $stat['langues'];
                        }
                        ?>
                        <?= $langue_nom ?> : <?= $stat['nombre'] ?> cours
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>    <script>
        function afficherFormulaireCours() {
            document.getElementById("formAjoutCours").style.display = "block";
        }

        function annulerFormulaire() {
            document.getElementById("formAjoutCours").style.display = "none";
            // Reset form
            document.getElementById("formAjoutCours").reset();
        }

        function afficherFormulaireLangue() {
            document.getElementById("formAjoutLangue").style.display = "block";
        }

        function afficherFormulaireSupprimerLangue() {
            document.getElementById("formSupprimerLangue").style.display = "block";
        }

        function filtrerCours() {
            let langue = document.getElementById("langue").value;
            
            $.ajax({
                url: '../backend/admin_backend.php',
                method: 'POST',
                data: {
                    action: 'get_courses',
                    langue: langue
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        updateCoursesTable(response.courses);
                    } else {
                        alert('Erreur lors du filtrage des cours');
                    }
                },
                error: function() {
                    alert('Erreur de communication avec le serveur');
                }
            });
        }

        function updateCoursesTable(courses) {
            let tableBody = '';
            courses.forEach(function(course) {
                tableBody += `<tr>
                    <td>${course.id}</td>
                    <td>${course.titre}</td>
                    <td>${course.langues}</td>
                    <td>${course.niveau}</td>
                    <td>${course.duree_minutes} min</td>
                    <td><button class="delete" onclick="deleteCourse(${course.id})">Supprimer</button></td>
                </tr>`;
            });
            
            document.getElementById("coursesTable").innerHTML = 
                '<tr><th>ID</th><th>Titre</th><th>Langue</th><th>Niveau</th><th>Durée</th><th>Action</th></tr>' + 
                tableBody;
        }

        function ajouterCours() {
            let titre = document.getElementById("nomCours").value;
            let description = document.getElementById("descriptionCours").value;
            let langue = document.getElementById("langueSelectCours").value;
            let niveau = document.getElementById("niveauCours").value;
            let duree = document.getElementById("dureeCours").value;
            let videoUrl = document.getElementById("videoUrl").value;

            if (!titre || !langue) {
                alert('Veuillez remplir au moins le titre et la langue');
                return;
            }

            $.ajax({
                url: '../backend/admin_backend.php',
                method: 'POST',
                data: {
                    action: 'add_course',
                    titre: titre,
                    description: description,
                    langue: langue,
                    niveau: niveau,
                    duree: duree,
                    video_url: videoUrl
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Cours ajouté avec succès');
                        location.reload(); // Recharger la page pour voir le nouveau cours
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Erreur de communication avec le serveur');
                }
            });
        }

        function deleteUser(userId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                $.ajax({
                    url: '../backend/admin_backend.php',
                    method: 'POST',
                    data: {
                        action: 'delete_user',
                        user_id: userId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Utilisateur supprimé');
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Erreur de communication avec le serveur');
                    }
                });
            }
        }

        function deleteCourse(courseId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')) {
                $.ajax({
                    url: '../backend/admin_backend.php',
                    method: 'POST',
                    data: {
                        action: 'delete_course',
                        course_id: courseId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Cours supprimé');
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Erreur de communication avec le serveur');
                    }
                });
            }
        }
    </script>
</body>
</html>
 