<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Éducation Bilingue</title>
    <link rel="stylesheet" href="../css/admin.css">
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

    <main>
        <!-- Liste des utilisateurs -->
        <section id="utilisateurs">
            <h2>Liste des utilisateurs</h2>
            <table>
                <tr><th>ID</th><th>Nom</th><th>Email</th><th>Action</th></tr>
                <tr><td>1</td><td>Jean Dupont</td><td>jean@example.com</td><td><button class="delete">Supprimer</button></td></tr>
            </table>
        </section>

        <!-- Gestion des cours -->
        <section id="cours">
            <h2>Gestion des cours</h2>
            <label for="langue">Filtrer par langue :</label>
            <select id="langue">
                <option value="fr">Français</option>
                <option value="en">Anglais</option>
            </select>
            <button onclick="filtrerCours()">Voir les cours</button>

            <table>
                <tr><th>Nom du cours</th><th>Langue</th><th>Action</th></tr>
                <tr><td>Mathématiques</td><td>Français</td><td><button class="delete">Supprimer</button></td></tr>
                <tr><td>English Grammar</td><td>Anglais</td><td><button class="delete">Supprimer</button></td></tr>
            </table>

            <button onclick="afficherFormulaireCours()">Ajouter un cours</button>

            <form id="formAjoutCours" style="display:none;">
                <label for="nomCours">Nom du cours :</label>
                <input type="text" id="nomCours" required>
                <label for="langueSelectCours">Langue :</label>
                <select id="langueSelectCours">
                    <option value="fr">Français</option>
                    <option value="en">Anglais</option>
                </select>
                <button type="submit">Confirmer</button>
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
        </section>

        <!-- Statistiques des leçons -->
        <section id="statistiques">
            <h2>Statistiques des leçons</h2>
            <p>Nombre de leçons par langue :</p>
            <ul><li>Français : 15 leçons</li><li>Anglais : 20 leçons</li></ul>
        </section>
    </main>

    <script>
        function afficherFormulaireCours() {
            document.getElementById("formAjoutCours").style.display = "block";
        }

        function afficherFormulaireLangue() {
            document.getElementById("formAjoutLangue").style.display = "block";
        }

        function afficherFormulaireSupprimerLangue() {
            document.getElementById("formSupprimerLangue").style.display = "block";
        }

        function filtrerCours() {
            let langue = document.getElementById("langue").value;
            alert("Affichage des cours en " + (langue === "fr" ? "Français" : "Anglais"));
        }
    </script>
</body>
</html>
 