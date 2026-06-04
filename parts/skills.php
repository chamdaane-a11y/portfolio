<?php
if (!isset($_SESSION)) {
    session_start();
}
$userCompetences = [];
if (isset($_SESSION['user_id'])) {
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../db_helpers.php';
    $userCompetences = getCompetencesByUser($connexion, (int) $_SESSION['user_id']);
}
$defaultCompetences = [
    [
        'type' => 'Data Science (en évolution)',
        'titre' => 'Analyse et exploitation de données, compréhension des concepts fondamentaux, résolution de problèmes basés sur les données',
        'niveau' => 'en évolution',
    ],
    [
        'type' => 'Cybersécurité',
        'titre' => 'Notions de base en sécurité des systèmes et protection des données, logique algorithmique (Cesar, XOR, AES ...)',
        'niveau' => 'en évolution',
    ],
    [
        'type' => 'Programmation',
        'titre' => 'Python, résolution de problèmes',
        'niveau' => 'en évolution',
    ],
    [
        'type' => 'Développement Web',
        'titre' => 'HTML, CSS, JavaScript, React création d’interfaces simples',
        'niveau' => 'en évolution',
    ],
];
$competences = !empty($userCompetences) ? $userCompetences : $defaultCompetences;

/**
 * Choisit une icône boxicon selon le libellé de la compétence.
 */
function skillIcon(string $type): string {
    $t = mb_strtolower($type);
    if (str_contains($t, 'data'))                      return 'bx-bar-chart-alt-2';
    if (str_contains($t, 'cyber') || str_contains($t, 'sécur')) return 'bx-shield-quarter';
    if (str_contains($t, 'program') || str_contains($t, 'python')) return 'bx-code-alt';
    if (str_contains($t, 'web') || str_contains($t, 'dévelop'))    return 'bx-window-alt';
    if (str_contains($t, 'design'))                    return 'bx-palette';
    return 'bx-rocket';
}

/**
 * Déduit un pourcentage de maîtrise à partir du niveau (texte ou nombre).
 */
function skillPercent($niveau): int {
    if (is_numeric($niveau)) return (int) max(0, min(100, (int) $niveau));
    $n = mb_strtolower((string) $niveau);
    if (str_contains($n, 'expert') || str_contains($n, 'avanc'))   return 90;
    if (str_contains($n, 'intermédiaire') || str_contains($n, 'confirm')) return 75;
    if (str_contains($n, 'évolution') || str_contains($n, 'cours')) return 65;
    if (str_contains($n, 'débutant') || str_contains($n, 'base'))   return 50;
    return 70;
}
?>
<section id="compétences">
    <div class="skills">
        <div class="section-head reveal">
            <span class="section-eyebrow">Ce que je maîtrise</span>
            <h2 class="section-title-xl">Mes compétences</h2>
        </div>

        <div class="skills-grid">
            <?php foreach ($competences as $i => $competence): ?>
                <?php
                $pct  = skillPercent($competence['niveau'] ?? '');
                $icon = skillIcon($competence['type'] ?? '');
                $delay = 0.05 * $i;
                ?>
                <article class="skill-card reveal" style="--d:<?php echo $delay; ?>s">
                    <span class="skill-icon"><i class='bx <?php echo $icon; ?>'></i></span>
                    <h3><?php echo htmlspecialchars($competence['type']); ?></h3>
                    <p><?php echo htmlspecialchars($competence['titre']); ?></p>
                    <div class="skill-bar" data-level="<?php echo $pct; ?>"><span></span></div>
                    <div class="skill-meta">
                        <span><?php echo htmlspecialchars($competence['niveau'] ?? 'Niveau'); ?></span>
                        <span class="pct"><?php echo $pct; ?>%</span>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
