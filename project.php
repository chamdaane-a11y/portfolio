<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db_helpers.php';

$defaultProjects = [
    [
        'id_projet' => 1,
        'titre' => 'Projet A',
        'description' => 'Analyse des tendances et du comportement de la clientèle d\'une base de données nommée CVC.',
        'image_url' => 'image2.png',
    ],
    [
        'id_projet' => 2,
        'titre' => 'Projet B',
        'description' => 'Analyse des facteurs déterminants la mortalité et la durée de séjour en soin intensif de la base de donnée clinique.',
        'image_url' => 'clinic.png',
    ],
    [
        'id_projet' => 3,
        'titre' => 'Projet C',
        'description' => 'Réalisation d\'une application de Gestion de tâche utilisable par tous.',
        'image_url' => 'image1.png',
    ],
];

$userProjects = [];
if (isset($_SESSION['user_id'])) {
    $userProjects = getProjectsByUser($connexion, (int) $_SESSION['user_id']);
}

$projects = !empty($userProjects) ? $userProjects : $defaultProjects;

$projectId = null;
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $projectId = (int) $_GET['id'];
}

$selectedProject = null;
foreach ($projects as $project) {
    if (isset($project['id_projet']) && $project['id_projet'] === $projectId) {
        $selectedProject = $project;
        break;
    }
}

if ($selectedProject === null && $projectId !== null) {
    // If project IDs are not present in DB results, match by position.
    foreach ($projects as $index => $project) {
        if ($projectId === $index + 1) {
            $selectedProject = $project;
            break;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<?php include __DIR__ . '/parts/head.php'; ?>
<body>
    <?php include __DIR__ . '/parts/nav.php'; ?>

    <main>
        <section id="project-detail" class="project-detail">
            <div class="container">
                <?php if ($selectedProject): ?>
                    <h1><?php echo htmlspecialchars($selectedProject['titre']); ?></h1>
                    <p><?php echo htmlspecialchars($selectedProject['description']); ?></p>
                    <div class="container">
                        <img src="<?php echo htmlspecialchars($selectedProject['image_url']); ?>" alt="<?php echo htmlspecialchars($selectedProject['titre']); ?>">
                    </div>
                    <p><a href="index.php?page=projets">Retour à mes projets</a></p>
                <?php else: ?>
                    <h1>Projet non trouvé</h1>
                    <p>Le projet demandé n'existe pas ou l'identifiant n'est pas valide.</p>
                    <p><a href="index.php?page=projets">Retour à mes projets</a></p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/parts/footer.php'; ?>
</body>
</html>
