# Portfolio — Hamdaane CHITOU

Portfolio personnel interactif (PHP + MySQL) d'un étudiant en **Data Science & Digitalisation**.
Thème sombre, accent bleu, et une couche d'animations modernes.

## ✨ Fonctionnalités

- **Architecture multi-pages** en PHP (Accueil, Compétences, Projets, Contact) avec routage sécurisé par liste blanche.
- **Données dynamiques** depuis MySQL (profil, compétences, projets) avec contenus par défaut en l'absence de session.
- **Hero animé** : badge de disponibilité, titre en dégradé, effet machine à écrire, boutons d'action.
- **Compétences** en cartes *glassmorphism* avec barres de progression animées et effet *tilt 3D*.
- **Projets** présentés dans un **carrousel 3D (coverflow)** : flèches, points, clavier, swipe, lecture auto.
- **Contact** : formulaire + panneau d'infos + liens réseaux (GitHub, LinkedIn, Instagram, Gmail).
- **Détails premium** : fond aurora + particules animées (canvas), curseur personnalisé, barre de progression de scroll, révélations au défilement.
- **Accessibilité** : respect de `prefers-reduced-motion`, navigation clavier, design responsive (mobile → desktop).

## 🛠️ Stack

- PHP (mysqli)
- MySQL / MariaDB
- HTML, CSS (vanilla, custom properties), JavaScript (vanilla)
- [Boxicons](https://boxicons.com/) pour les icônes

## 🌐 Déploiement (Vercel — version statique)

Le site est aussi disponible en **version statique** (`index.html`) déployable sur **Vercel** :
contenu, animations, carrousel 3D et SEO inclus, sans serveur PHP.

1. Aller sur [vercel.com](https://vercel.com) → se connecter avec GitHub.
2. **Add New… → Project** → importer le dépôt `portfolio`.
3. Framework : **Other** (aucun build) → **Deploy**.
4. Renommer le projet en `hamdaane-chitou` pour obtenir `https://hamdaane-chitou.vercel.app`.

> ℹ️ Vercel n'exécute pas PHP : c'est `index.html` (statique) qui est servi. La version PHP reste utilisable en local.

## 🚀 Installation (version PHP, en local)

1. **Cloner le dépôt**
   ```bash
   git clone https://github.com/chamdaane-a11y/portfolio.git
   cd portfolio
   ```

2. **Configurer la base de données**
   ```bash
   cp config.example.php config.php
   # puis renseigner DB_USER / DB_PASS dans config.php
   ```

3. **Importer le schéma**
   ```bash
   mysql -u root -p portofolio < portfolio.sql
   ```

4. **Lancer en local**
   ```bash
   php -S localhost:8000
   ```
   Puis ouvrir <http://localhost:8000/index.php>.

## 📁 Structure

```
.
├── index.php            # Point d'entrée + routeur
├── parts/               # Composants (head, nav, home, skills, projects, contact, footer)
├── enhance.css          # Couche visuelle premium
├── enhance.js           # Couche interactive (carrousel, particules, reveals…)
├── style.css            # Styles de base & responsive
├── config.example.php   # Modèle de configuration BDD
├── portfolio.sql        # Schéma + données de démonstration
└── *.png / *.jpeg       # Médias
```

## 🔒 Sécurité

Le fichier `config.php` (identifiants réels) est exclu via `.gitignore` et ne doit **jamais** être publié.

---

Conçu avec ❤️ par Hamdaane CHITOU.
