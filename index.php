<?php
session_start();

// Page demandée, 'home' par défaut
$page = isset($_GET['page']) ? trim($_GET['page']) : 'home';

// Pages autorisées (whitelist sécurité)
$pages_autorisees = ['home', 'competences', 'projets', 'contact'];

if (!in_array($page, $pages_autorisees)) {
    $page = 'home';
}

// Correspondance page → fichier part
$parts_map = [
    'home'        => 'parts/home.php',
    'competences' => 'parts/skills.php',
    'projets'     => 'parts/projects.php',
    'contact'     => 'parts/contact.php',
];
?>
<!DOCTYPE html>
<html lang="fr">

<?php include __DIR__ . '/parts/head.php'; ?>

<body>

    <?php include __DIR__ . '/parts/nav.php'; ?>

    <main>
        <?php include __DIR__ . '/' . $parts_map[$page]; ?>
    </main>

    <?php include __DIR__ . '/parts/footer.php'; ?>

</body>
</html>