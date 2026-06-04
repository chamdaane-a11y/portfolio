<?php
if (!isset($_SESSION)) {
    session_start();
}
$user = null;
if (isset($_SESSION['user_id'])) {
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../db_helpers.php';
    $user = getUserById($connexion, (int) $_SESSION['user_id']);
}

$defaultBio = "Je me spécialise dans l'analyse de données, la programmation et les systèmes numériques. "
    . "En tant que futur Data Scientist, je développe des compétences solides en Python, en traitement de "
    . "données et en résolution de problèmes complexes. Je m'intéresse également à la cybersécurité, un "
    . "domaine essentiel pour garantir la fiabilité et la protection des systèmes informatiques. "
    . "Rigoureux, curieux et orienté résultats, je m'investis dans chaque projet avec l'objectif de "
    . "concevoir des solutions pertinentes, innovantes et adaptées aux besoins réels. "
    . "Mon ambition est de mettre la data au service de la prise de décision et de l'innovation.";

$homeTitle    = $user ? trim($user['prenom'] . ' ' . $user['nom']) : 'Hamdaane CHITOU';
$homeSubtitle = $user ? $user['titre_professionnel']               : 'Étudiant en Data Science et Digitalisation';
$homeBio      = $user ? $user['bio']                               : $defaultBio;

// Normalise le chemin image (supprime ./ ou / en début)
$rawImage  = $user ? $user['photo'] : 'hamdaane.jpeg';
$homeImage = ltrim(trim($rawImage), './');
?>
<section id="Acceuil">
    <div class="home">
        <span class="hero-badge reveal" style="--d:0s">
            <span class="pulse"></span> Disponible pour de nouveaux projets
        </span>

        <h1 class="reveal" style="--d:0.08s">
            Bonjour, je suis <span class="grad-text"><?php echo htmlspecialchars($homeTitle); ?></span>
        </h1>

        <h2 class="reveal" style="--d:0.16s">
            <span class="type-target" data-words="<?php echo htmlspecialchars($homeSubtitle); ?>|Futur Data Scientist|Passionné de cybersécurité|Développeur web"></span>
        </h2>

        <p class="reveal" style="--d:0.24s"><?php echo nl2br(htmlspecialchars($homeBio)); ?></p>

        <div class="hero-cta reveal" style="--d:0.32s">
            <a href="index.php?page=projets" class="btn btn-primary">
                <i class='bx bx-rocket'></i> Voir mes projets
            </a>
            <a href="index.php?page=contact" class="btn btn-ghost">
                <i class='bx bx-envelope'></i> Me contacter
            </a>
        </div>

        <div class="hamo-profile reveal reveal-zoom" style="--d:0.4s">
            <img src="<?php echo htmlspecialchars($homeImage); ?>"
                 alt="Profil de <?php echo htmlspecialchars($homeTitle); ?>"
                 onerror="this.style.display='none'">
        </div>
    </div>

    <a href="index.php?page=competences" class="scroll-hint" aria-label="Découvrir mes compétences">
        <span class="mouse"><span class="wheel"></span></span>
        Explorer
    </a>
</section>