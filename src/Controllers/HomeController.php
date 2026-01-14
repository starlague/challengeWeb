<?php
namespace App\Controllers;

use App\Database;

class HomeController {
    public function index() {
        $pdo = Database::getInstance();

        // Si formulaire soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['title']) && !empty($_POST['content'])) {
            $idUser = 1; // temporaire : ID utilisateur connecté
            $stmt = $pdo->prepare("INSERT INTO post (idUser, title, content) VALUES (:idUser, :title, :content)");
            $stmt->execute([
                ':idUser' => $idUser,
                ':title' => $_POST['title'],
                ':content' => $_POST['content']
            ]);
            header("Location: /");
            exit;
        }

        // Récupérer tous les posts
        $stmt = $pdo->query("
            SELECT p.title, p.content, u.username
            FROM post p
            JOIN users u ON p.idUser = u.id
            ORDER BY p.id DESC
        ");
        $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Générer le contenu HTML
        $content = '<h2>Créer un post</h2>
                    <form method="post">
                        <input type="text" name="title" placeholder="Titre" required><br><br>
                        <textarea name="content" placeholder="Écris ton post..." required></textarea><br><br>
                        <button type="submit">Publier</button>
                    </form>';

        $content .= '<h2>Posts récents</h2>';
        foreach ($posts as $post) {
            $content .= '<div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                            <h3>' . htmlspecialchars($post['title']) . '</h3>
                            <p>' . nl2br(htmlspecialchars($post['content'])) . '</p>
                            <small>Par ' . htmlspecialchars($post['username']) . '</small>
                         </div>';
        }

        return [
            'title' => 'Accueil',
            'content' => $content
        ];
    }
}
