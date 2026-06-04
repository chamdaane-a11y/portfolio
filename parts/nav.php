<?php
if (!isset($_SESSION)) session_start();

// Page active pour surligner le bon lien
$currentPage = isset($_GET['page']) ? trim($_GET['page']) : 'home';

$currentUser = 'Invité';
if (isset($_SESSION['user_id'])) {
    try {
        require_once __DIR__ . '/../db_helpers.php';
        require_once __DIR__ . '/../config.php';
        $user = getUserById($connexion, (int) $_SESSION['user_id']);
        if ($user) {
            $currentUser = trim($user['prenom'] . ' ' . $user['nom']);
            $_SESSION['user_name'] = $currentUser;
        } else {
            $currentUser = $_SESSION['user_name'] ?? ('User#' . $_SESSION['user_id']);
        }
    } catch (Throwable $e) {
        $currentUser = $_SESSION['user_name'] ?? ('User#' . $_SESSION['user_id']);
    }
}
$initiales = strtoupper(mb_substr($currentUser, 0, 1));

// Helper : classe "active" si page courante
function navActive(string $page, string $current): string {
    return $page === $current ? ' class="active"' : '';
}
?>

<header class="header">

    <!-- Logo -->
    <a href="index.php" class="logo">CHAMDAANE<span class="logo-ghost">(#GHOST)</span></a>

    <!-- Bouton hamburger (mobile uniquement) -->
    <button class="hamburger" id="hamburger" aria-label="Ouvrir le menu" aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <!-- Nav principale -->
    <nav class="navbar" id="navbar">
        <a href="index.php?page=home"<?php echo navActive('home', $currentPage); ?>>Accueil</a>
        <a href="index.php?page=competences"<?php echo navActive('competences', $currentPage); ?>>Mes compétences</a>
        <a href="index.php?page=projets"<?php echo navActive('projets', $currentPage); ?>>Mes projets</a>
        <a href="index.php?page=contact"<?php echo navActive('contact', $currentPage); ?>>Contact</a>
    </nav>

    <!-- Panneau utilisateur -->
    <div class="user-panel" id="user-panel">

        <button class="user-avatar" id="user-avatar-btn"
                aria-haspopup="true" aria-expanded="false"
                aria-label="Menu utilisateur">
            <span class="avatar-letter"><?php echo htmlspecialchars($initiales); ?></span>
            <span class="avatar-name"><?php echo htmlspecialchars($currentUser); ?></span>
            <i class='bx bx-chevron-down avatar-chevron'></i>
        </button>

        <div class="user-dropdown" id="user-dropdown" role="menu">
            <div class="dropdown-info">
                <span class="dropdown-label">Connecté en tant que</span>
                <strong><?php echo htmlspecialchars($currentUser); ?></strong>
            </div>
            <div class="dropdown-divider"></div>
            <form action="login.php" method="get" class="dropdown-switch">
                <label for="user_switch">Changer d'utilisateur</label>
                <div class="switch-row">
                    <select name="user_id" id="user_switch">
                        <option value="1">Hamdaane (1)</option>
                        <option value="2">Jean DesChamps (2)</option>
                        <option value="3">Paul Pogba (3)</option>
                    </select>
                    <button type="submit" class="btn-switch">OK</button>
                </div>
            </form>
            <div class="dropdown-divider"></div>
            <a href="logout.php" class="dropdown-logout">
                <i class='bx bx-log-out'></i> Déconnexion
            </a>
        </div>
    </div>

    <!-- Overlay -->
    <div class="nav-overlay" id="nav-overlay"></div>

</header>

<script>
(function () {
    const hamburger = document.getElementById('hamburger');
    const navbar    = document.getElementById('navbar');
    const overlay   = document.getElementById('nav-overlay');
    const avatarBtn = document.getElementById('user-avatar-btn');
    const dropdown  = document.getElementById('user-dropdown');

    // Hamburger
    hamburger.addEventListener('click', () => {
        const isOpen = navbar.classList.toggle('open');
        overlay.classList.toggle('open', isOpen);
        hamburger.classList.toggle('open', isOpen);
        hamburger.setAttribute('aria-expanded', isOpen);
        document.body.style.overflow = isOpen ? 'hidden' : '';
        closeDropdown();
    });

    // Fermer le menu au clic overlay
    overlay.addEventListener('click', closeMenu);

    window.closeMenu = function () {
        navbar.classList.remove('open');
        overlay.classList.remove('open');
        hamburger.classList.remove('open');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    };

    // En mode multi-page il n'y a plus de scroll, on retire cet écouteur
    // Dropdown utilisateur
    avatarBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = dropdown.classList.toggle('open');
        avatarBtn.setAttribute('aria-expanded', isOpen);
        if (isOpen) closeMenu();
    });

    function closeDropdown() {
        dropdown.classList.remove('open');
        avatarBtn.setAttribute('aria-expanded', 'false');
    }

    document.addEventListener('click', (e) => {
        if (!e.target.closest('#user-panel')) closeDropdown();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') { closeMenu(); closeDropdown(); }
    });
})();
</script> 