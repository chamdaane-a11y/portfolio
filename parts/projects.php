<?php
if (!isset($_SESSION)) {
    session_start();
}
$userProjects = [];
if (isset($_SESSION['user_id'])) {
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../db_helpers.php';
    $userProjects = getProjectsByUser($connexion, (int) $_SESSION['user_id']);
}
$defaultProjects = [
    [
        'titre'       => 'Projet A',
        'description' => 'Analyse des tendances et du comportement de la clientèle d\'une base de données nommée CVC.',
        'image_url'   => 'image2.png',
    ],
    [
        'titre'       => 'Projet B',
        'description' => 'Analyse des facteurs déterminants la mortalité et la durée de séjour en soin intensif de la base de données clinique.',
        'image_url'   => 'clinic.png',
    ],
    [
        'titre'       => 'Projet C',
        'description' => 'Réalisation d\'une application de gestion de tâche utilisable par tous.',
        'image_url'   => 'image1.png',
    ],
];
$projects = !empty($userProjects) ? $userProjects : $defaultProjects;

/**
 * Normalise le chemin image :
 * supprime ./ ou / en début pour toujours avoir un chemin relatif propre
 * ex: "./image2.png" → "image2.png"
 *     "/uploads/img.png" → "uploads/img.png"
 */
function normalizeImagePath(string $path): string {
    return ltrim(trim($path), './');
}
?>
<section id="projets">
    <div class="projets">
        <div class="section-head reveal">
            <span class="section-eyebrow">Réalisations</span>
            <h2 class="section-title-xl">Mes projets</h2>
        </div>

        <div class="carousel-3d reveal" data-autoplay="5500">
            <button class="car-nav car-prev" aria-label="Projet précédent"><i class='bx bx-chevron-left'></i></button>

            <div class="carousel-stage">
            <?php foreach ($projects as $key => $project): ?>
                <?php
                $projectId   = $project['id_projet'] ?? ($key + 1);
                $projectLink = 'project.php?id=' . urlencode($projectId);
                $imagePath   = normalizeImagePath($project['image_url'] ?? '');
                ?>
                <article class="project-card">
                    <?php if ($imagePath): ?>
                    <div class="project-thumb">
                        <span class="project-tag">Projet</span>
                        <img src="<?php echo htmlspecialchars($imagePath); ?>"
                             alt="<?php echo htmlspecialchars($project['titre']); ?>"
                             loading="lazy"
                             onerror="this.closest('.project-thumb').style.display='none'">
                    </div>
                    <?php endif; ?>
                    <div class="project-body">
                        <h3><?php echo htmlspecialchars($project['titre']); ?></h3>
                        <p><?php echo htmlspecialchars($project['description']); ?></p>
                        <a class="project-link-btn" href="<?php echo htmlspecialchars($projectLink); ?>">
                            Voir le détail <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
            </div>

            <button class="car-nav car-next" aria-label="Projet suivant"><i class='bx bx-chevron-right'></i></button>
            <div class="car-dots" aria-hidden="true"></div>
        </div>
    </div>
</section>