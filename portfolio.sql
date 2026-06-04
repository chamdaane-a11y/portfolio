create DATABASE portofolio;
USE portofolio;

create TABLE users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(100) NOT NULL,   
    mot_de_passe VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    bio TEXT NOT NULL,
    titre_professionnel varchar(255) NOT NULL,
    photo VARCHAR(255) NOT NULL
);

insert into users (id_user, nom, prenom, mot_de_passe, email, bio, titre_professionnel, photo) values
(1, 'CHITOU', 'Hamdaane', 'password123', 'chamdaane@gmail.com', 'Hello, je suis Hamdaane CHITOU

                Étudiant en Data Science et Digitalisation
                je me spécialise dans l’analyse de données, la
                    programmation
                    et les systèmes numériques.

                En tant que futur Data Scientist, je développe des compétences solides en Python, en traitement de
                    données et en résolution de problèmes complexes. Je m’intéresse également à la cybersécurité, un
                    domaine
                    essentiel pour garantir la fiabilité et la protection des systèmes informatiques.</p>

                    Rigoureux, curieux et orienté résultats, je m’investis dans chaque projet avec l’objectif de
                    concevoir
                    des solutions pertinentes, innovantes et adaptées aux besoins réels.</p>

                    Mon ambition est de mettre la data au service de la prise de décision et de l’innovation.', 'Etudiant', '.hamo.png');

-- Utilisateurs supplémentaires pour tests de basculement
insert into users (id_user, nom, prenom, mot_de_passe, email, bio, titre_professionnel, photo) values
(2, 'DesChamps', 'Jean', 'password456', 'jean.deschamps@example.com', 'Jean DesChamps est un développeur passionné par les applications web et la transformation digitale. Il aime créer des interfaces performantes et travailler sur des projets qui améliorent l’expérience utilisateur. Son approche est orientée qualité, testabilité et collaboration.', 'Développeur', '.jean.png'),
(3, 'Pogba', 'Paul', 'password789', 'paul.pogba@example.com', 'Paul Pogba est un analyste polyvalent spécialisé dans l’analyse métier et la cybersécurité. Il conçoit des solutions fiables, sécurisées et adaptées aux besoins des clients, avec une attention particulière à la communication entre les équipes techniques et métier.', 'Analyste', '.paul.png');

create TABLE projets (
    id_projet INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    lien_demo VARCHAR(255) NOT NULL,
    id_user INT,
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);

insert into projets (id_projet, titre, description, image_url, lien_demo, id_user) values
(1, 'Projet A', 'Analyse des tendances et du comportement de la clientèle d_une base
                        de données nommée CVC.', 'projet1.png', 'https://example.com/demo1', 1),
(2, 'Projet B', ' Analyse des facteurs déterminants la mortalité et la durée de séjour
                        en soin intensif de la base de donnée clinique', 'projet2.png', 'https://example.com/demo2', 1),
(3, 'Projet C', ' Réalisation d_une application de Gestion de tâche utilisable par
                        tous.', 'projet3.png', 'https://example.com/demo3', 1),
(4, 'Projet D', 'Création d_un tableau de bord analytique pour le suivi des ventes.', 'projet4.png', 'https://example.com/demo4', 2),
(5, 'Projet E', 'Développement d_une plateforme de planification pour petites entreprises.', 'projet5.png', 'https://example.com/demo5', 2),
(6, 'Projet F', 'Audit de sécurité et recommandations pour un service web.', 'projet6.png', 'https://example.com/demo6', 3);



create table Messages (
    id_message INT PRIMARY KEY AUTO_INCREMENT,
    `nom-exp` VARCHAR(50) NOT NULL,
    `mail-exp` VARCHAR(255) NOT NULL,
    sujet VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    date_envoie DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id_user)
);


create table Competences (
    id_competence INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(255) NOT NULL,
    titre VARCHAR(255) NOT NULL,
    niveau VARCHAR(50) NOT NULL,
    icon_url VARCHAR(255) NOT NULL,
    id_user INT,
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);

insert into Competences (id_competence, type, titre, niveau, icon_url, id_user) values

(1, 'Data Science ', 'Analyse et exploitation de données,
                        compréhension des concepts
                        fondamentaux, résolution de problèmes basés sur les données',  'en évolution', 'python-icon.png', 1),
(2,'Cybersécurité',' Notions de base en sécurité des systèmes et protection des
                        données, logique
                        algorithmique(Cesar, XOR, AES ...)', 'en évolution', 'r-icon.png', 1),
(3, 'Programmation ', 'Python, résolution de problèmes',' en évolution', 'network-security-icon.png', 1),
(4, 'Gestion de projet', 'Organisation de sprints et coordination d_equipes', 'avancé', 'project-icon.png', 2),
(5, 'Développement web', 'Création de pages et composants modernes', 'intermédiaire', 'web-icon.png', 2),
(6, 'Analyse métier', 'Rédaction de cahiers des charges et suivi client', 'intermédiaire', 'analysis-icon.png', 2),
(7, 'Cybersécurité', 'Détection de vulnérabilités et gestion des risques', 'avancé', 'security-icon.png', 3),
(8, 'Réseaux', 'Configuration de serveurs et surveillance des infrastructures', 'intermédiaire', 'network-icon.png', 3),
(9, 'Cloud', 'Déploiement et maintenance d_applications dans le cloud', 'intermédiaire', 'cloud-icon.png', 3);
