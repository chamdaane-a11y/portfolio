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
$contactName = $user ? trim($user['prenom'] . ' ' . $user['nom']) : 'Hamdaane CHITOU';
$contactEmail = $user ? $user['email'] : 'chamdaane@gmail.com';
?>
<section id="Contact">
    <div class="contact-section reveal">
        <div class="section-head">
            <span class="section-eyebrow">Restons en contact</span>
            <h2 class="section-title-xl">Contactez <?php echo htmlspecialchars($contactName); ?></h2>
        </div>

        <div class="contact-grid">
        <div class="contact-form-wrap">

        <?php
        if (isset($_SESSION['succes'])) {
            echo '<div style="color: green; padding: 10px; margin-bottom: 20px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px;">' . htmlspecialchars($_SESSION['succes']) . '</div>';
            unset($_SESSION['succes']);
        }
        if (isset($_SESSION['erreurs'])) {
            echo '<div style="color: red; padding: 10px; margin-bottom: 20px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px;"><ul style="margin: 0;">';
            foreach ($_SESSION['erreurs'] as $erreur) {
                echo '<li>' . htmlspecialchars($erreur) . '</li>';
            }
            echo '</ul></div>';
            unset($_SESSION['erreurs']);
        }
        ?>

        <form class="contact-form" action="contact_process.php" method="post">
            <div class="form-group">
                <label for="nom">Nom complet <span class="required"></span></label>
                <input type="text" id="nom" name="nom" required placeholder="Votre nom complet">
            </div>

            <div class="form-group">
                <label for="email">Adresse Email <span class="required"></span></label>
                <input type="email" id="email" name="email" required placeholder="votre.email@example.com">
            </div>

            <div class="form-group">
                <label for="sujet">Sujet</label>
                <input type="text" id="sujet" name="sujet" placeholder="Sujet de votre message">
            </div>

            <div class="form-group">
                <label for="message">Message <span class="required"></span></label>
                <textarea id="message" name="message" rows="5" required
                    placeholder="Votre message..."></textarea>
            </div>

            <button type="submit" class="btn-submit"><i class='bx bx-send'></i> Envoyer le message</button>
        </form>
        </div><!-- /.contact-form-wrap -->

        <aside class="contact-aside">
            <p>Une question, une opportunité ou simplement envie d'échanger ? Je réponds rapidement, n'hésitez pas&nbsp;!</p>

            <a class="contact-info-item" href="mailto:<?php echo htmlspecialchars($contactEmail); ?>">
                <i class='bx bx-envelope'></i>
                <span><?php echo htmlspecialchars($contactEmail); ?></span>
            </a>
            <div class="contact-info-item">
                <i class='bx bx-map'></i>
                <span>Disponible en télétravail / sur site</span>
            </div>
            <div class="contact-info-item">
                <i class='bx bx-time-five'></i>
                <span>Réponse sous 24–48&nbsp;h</span>
            </div>

            <div class="socials">
                <a class="social-link" href="mailto:<?php echo htmlspecialchars($contactEmail); ?>" aria-label="Email" title="Email"><i class='bx bxl-gmail'></i></a>
                <a class="social-link" href="https://github.com/chamdaane-a11y" target="_blank" rel="noopener noreferrer" aria-label="GitHub" title="GitHub"><i class='bx bxl-github'></i></a>
                <a class="social-link" href="https://www.linkedin.com/in/hamdaane-chitou-9249b9390/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" title="LinkedIn"><i class='bx bxl-linkedin'></i></a>
                <a class="social-link" href="https://www.instagram.com/hamdaane.chitou" target="_blank" rel="noopener noreferrer" aria-label="Instagram" title="Instagram"><i class='bx bxl-instagram'></i></a>
                <a class="social-link" href="https://wa.me/2290156383374" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" title="WhatsApp"><i class='bx bxl-whatsapp'></i></a>
            </div>
        </aside>
        </div><!-- /.contact-grid -->
    </div>
</section>
