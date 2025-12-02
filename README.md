# IAdventure - Application Symfony 7.4

Application ludique et pédagogique pour découvrir des domaines informatiques (IA, Cybersécurité, etc.) en équipe.

## 📋 Description

IAdventure propose des ateliers informatiques pour des petits groupes de 10 à 15 élèves de 3ème, pendant 40 minutes. Les énigmes sont personnalisables par les professeurs.

### Caractéristiques principales

- **Jeu sans identification pour les élèves** : Les élèves jouent en équipe sans avoir besoin de compte
- **Interface professeur sécurisée** : Authentification requise pour gérer les jeux
- **Suivi en temps réel** : Les enseignants peuvent suivre la progression des équipes
- **Énigmes personnalisables** : Création et gestion de différents types d'énigmes
- **Historique complet** : Consultation de l'historique des parties jouées

## 🚀 Installation

### Prérequis

- PHP 8.2 ou supérieur
- Composer
- Docker et Docker Compose (pour la base de données)
- Node.js (pour les assets)

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone https://github.com/KLenesley/IAdventure.git
cd IAdventure
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configurer l'environnement**
```bash
cp .env .env.local
# Éditer .env.local si nécessaire
```

4. **Démarrer la base de données MariaDB**
```bash
docker compose up -d database
```

5. **Créer la base de données et exécuter les migrations**
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

6. **Charger les données initiales (fixtures)**
```bash
php bin/console doctrine:fixtures:load
```

7. **Démarrer le serveur de développement**
```bash
symfony server:start
# ou
php -S localhost:8000 -t public
```

8. **Accéder à l'application**
- URL principale : http://localhost:8000
- Interface professeur : http://localhost:8000/teacher/game

## 👥 Comptes de test

Après avoir chargé les fixtures, les comptes suivants sont disponibles :

| Email | Mot de passe | Rôle |
|-------|-------------|------|
| prof@gmail.com | prof | Professeur |
| admin@gmail.com | admin | Administrateur |
| s-admin@gmail.com | s-admin | Super Administrateur |

## 📚 Structure du projet

### Entités principales

- **User** : Compte enseignant pour gérer les jeux
- **Game** : Jeu/domaine (IA, Cybersécurité, etc.)
- **Enigma** : Énigme d'un jeu avec son ordre, type et code secret
- **Type** : Type d'énigme (QCM, Carte, Vidéo, etc.)
- **Team** : Équipe d'élèves jouant sans authentification
- **GameSession** : Instance de jeu lancée
- **TeamSession** : Participation d'une équipe à une session
- **TeamProgress** : Timeline des événements (énigmes résolues, tentatives)
- **Avatar** : Avatar disponible pour les équipes
- **Thumbnail** : Images et informations associées aux énigmes
- **Setting** : Configuration d'un jeu

### Controllers

- **GameController** : CRUD des jeux (enseignants)
- **EnigmaController** : CRUD des énigmes (enseignants)
- **PlayController** : Interface de jeu (élèves, sans authentification)
- **DashboardController** : Suivi des parties (enseignants)
- **SecurityController** : Authentification
- **UserController** : Gestion des utilisateurs (admin)

## 🎮 Utilisation

### Pour les enseignants

1. **Se connecter** avec les identifiants professeur
2. **Créer un jeu** depuis "Mes Jeux"
3. **Ajouter des énigmes** au jeu
4. **Partager le lien** du jeu avec les élèves
5. **Suivre la progression** en temps réel depuis le tableau de bord

### Pour les élèves

1. **Accéder au lien** du jeu fourni par l'enseignant
2. **Créer une équipe** en choisissant un nom et un avatar
3. **Résoudre les énigmes** en entrant les codes secrets
4. **Progresser** jusqu'à la fin du jeu

## 🔧 Configuration

### Base de données

La configuration de la base de données se trouve dans le fichier `.env` :

```env
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```

### Sécurité

La configuration de sécurité dans `config/packages/security.yaml` :
- `/play` : Accès public (pour les élèves)
- `/teacher` : Requiert `ROLE_PROF`
- `/user` : Requiert `ROLE_ADMIN`

## 📊 Types d'énigmes disponibles

Par défaut, les types suivants sont créés :
- QCM (Questionnaire à choix multiples)
- Carte (Carte interactive)
- Vidéo
- Photo
- Timeline (Ligne temporelle)
- Association (Association d'éléments)
- Classification
- Comparaison
- Vrai/Faux
- Code (Code à trouver)

## 🛠️ Développement

### Commandes utiles

```bash
# Vider le cache
php bin/console cache:clear

# Créer une nouvelle migration
php bin/console doctrine:migrations:diff

# Vérifier la syntaxe des fichiers Twig
php bin/console lint:twig templates/

# Lister toutes les routes
php bin/console debug:router
```

## 📝 Licence

Ce projet est sous licence propriétaire.

## 👨‍💻 Auteur

KLenesley

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à ouvrir une issue ou une pull request.

## 📞 Support

Pour toute question ou problème, veuillez ouvrir une issue sur GitHub.
