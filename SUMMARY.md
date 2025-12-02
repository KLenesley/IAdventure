# IAdventure - Résumé du Projet

## Vue d'ensemble

IAdventure est une application Symfony 7.3 complète pour des ateliers informatiques ludiques destinés aux élèves de 3ème. Le projet permet aux enseignants de créer des jeux éducatifs personnalisés sur des thématiques comme l'Intelligence Artificielle ou la Cybersécurité.

## Architecture Technique

### Base de données (MariaDB 10.11)

**10 Entités Doctrine:**

1. **User** - Comptes enseignants et administrateurs
   - Email, mot de passe, rôles (ROLE_PROF, ROLE_ADMIN, ROLE_SUPER_ADMIN)
   - Authentification sécurisée

2. **Game** - Jeux créés par les enseignants
   - Titre, message de bienvenue, image
   - Relation avec créateur (User)

3. **Enigma** - Énigmes d'un jeu
   - Titre, instructions, code secret, ordre
   - Relations: Game, Type, Thumbnails

4. **Type** - Types d'énigmes
   - Label (QCM, Carte, Vidéo, Photo, etc.)

5. **Team** - Équipes d'élèves (SANS authentification)
   - Nom, position, énigme courante, note
   - Relation optionnelle avec Avatar

6. **GameSession** - Instance de jeu lancée
   - Dates de début/fin, statut
   - Relation avec Game

7. **TeamSession** - Participation d'une équipe à une session
   - Progression, statut (en cours/terminé)
   - Relations: Team, GameSession

8. **TeamProgress** - Timeline des événements
   - Action (démarré/complété/échec), timestamp, détails
   - Suivi précis de chaque tentative

9. **Avatar** - Avatars pour les équipes
   - Nom de fichier d'image

10. **Thumbnail** - Ressources des énigmes
    - Images, informations textuelles

11. **Setting** - Configuration de jeu
    - Paramètres spécifiques par jeu

### Contrôleurs (5 principaux)

1. **GameController** (/teacher/game)
   - CRUD complet des jeux
   - Réservé aux enseignants (ROLE_PROF)
   - Routes: index, new, show, edit, delete

2. **EnigmaController** (/teacher/game/{gameId}/enigma)
   - CRUD des énigmes
   - Gestion par jeu
   - Routes: index, new, edit, delete

3. **PlayController** (/play)
   - Interface de jeu SANS authentification
   - Création d'équipe dynamique
   - Validation des réponses
   - Routes: select_game, join, game, check

4. **DashboardController** (/teacher/dashboard)
   - Suivi en temps réel
   - Visualisation des sessions actives
   - Timeline de progression des équipes

5. **SecurityController** + UserController
   - Authentification enseignants
   - Gestion utilisateurs (admin)

### Voter de Sécurité

**GameVoter** - Contrôle d'accès aux jeux
- Permissions: view, edit, delete
- Règles: Créateur ou Admin

### Formulaires (4 types)

1. **GameType** - Création/édition de jeux
2. **EnigmaType** - Gestion des énigmes
3. **TeamType** - Création d'équipe (élèves)
4. **TypeFormType** - Gestion des types

### Templates Twig (15+)

**Organisation:**
- `game/` - Interface professeur (index, new, show, edit)
- `enigma/` - Gestion énigmes (index, new, edit)
- `play/` - Interface élèves (select_game, join, game)
- `dashboard/` - Suivi (index, game)
- `base.html.twig` - Layout principal avec navigation

## Fonctionnalités Clés

### Pour les Enseignants

✅ **Authentification sécurisée**
- Login par email/mot de passe
- Rôles hiérarchiques
- Protection CSRF

✅ **Gestion de jeux**
- Créer plusieurs jeux thématiques
- Personnaliser messages et images
- Ajouter/modifier/supprimer énigmes
- Définir ordre et types d'énigmes

✅ **Suivi en temps réel**
- Voir les équipes actives
- Progression par énigme
- Timeline complète des tentatives
- Historique des sessions

### Pour les Élèves

✅ **Accès sans compte**
- Pas d'inscription nécessaire
- Création d'équipe instantanée
- Choix d'avatar

✅ **Gameplay intuitif**
- Énigmes présentées dans l'ordre
- Validation immédiate des réponses
- Messages de succès/échec
- Barre de progression

✅ **Expérience collaborative**
- Jeu en équipe (10-15 élèves)
- Pas de smartphone requis
- Durée adaptée (40 minutes)

## Sécurité

### Implémentée

✅ **Authentification**
- Passwords hashés (auto)
- Protection des routes enseignants
- Accès public gameplay seulement

✅ **Autorisation**
- Voter pour contrôle d'accès
- Vérification propriétaire
- Hiérarchie de rôles

✅ **Codes secrets**
- Comparaison sensible à la casse
- Pas de limite de tentatives (pédagogique)

✅ **Protection CSRF**
- Tous les formulaires protégés
- Tokens dans suppression

## Configuration

### Environnement (.env)

```env
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```

### Docker (compose.yaml)

- Service MariaDB 10.11
- Port 3306 exposé
- Volume persistant

### Sécurité (security.yaml)

```yaml
access_control:
    - { path: ^/play, roles: PUBLIC_ACCESS }      # Élèves
    - { path: ^/teacher, roles: ROLE_PROF }       # Enseignants
    - { path: ^/user, roles: ROLE_ADMIN }         # Admin
```

## Données Initiales (Fixtures)

### Types d'énigmes (10)
- QCM, Carte, Vidéo, Photo
- Timeline, Association, Classification
- Comparaison, Vrai/Faux, Code

### Avatars (5)
- robot.png, astronaut.png
- detective.png, scientist.png, explorer.png

### Comptes de test (4)
- prof@gmail.com / prof (ROLE_PROF)
- admin@gmail.com / admin (ROLE_ADMIN)
- s-admin@gmail.com / s-admin (ROLE_SUPER_ADMIN)
- user@gmail.com / user (ROLE_USER)

## Flux d'Utilisation

### Scénario typique

1. **Enseignant prépare**
   - Se connecte
   - Crée un jeu "Découverte de l'IA"
   - Ajoute 5-10 énigmes avec codes secrets
   - Configure ordre et types

2. **Atelier démarre**
   - Enseignant partage lien du jeu
   - Élèves se divisent en équipes
   - Chaque équipe crée son nom + avatar

3. **Jeu se déroule**
   - Équipes résolvent énigmes
   - Enseignant suit progression
   - Timeline enregistre chaque action
   - Première équipe terminée gagne

4. **Après l'atelier**
   - Consultation de l'historique
   - Analyse des difficultés
   - Ajustement des énigmes

## Points Techniques Importants

### Design Patterns

- **Repository Pattern** - Accès données
- **Form Type Pattern** - Gestion formulaires
- **Voter Pattern** - Autorisation
- **Entity Relationships** - ORM Doctrine

### Bonnes Pratiques

✅ Séparation des préoccupations
✅ DRY (Don't Repeat Yourself)
✅ SOLID principles
✅ Annotations/Attributes PHP 8
✅ Type hints stricts
✅ Injection de dépendances

### Performance

- Lazy loading des relations
- Requêtes optimisées avec OrderBy
- Pagination intégrée (prête à activer)
- Cache Symfony

## Extension Possible

### Fonctionnalités futures

- 📊 Statistiques avancées
- 🏆 Système de points/classement
- 📱 Mode responsive mobile
- 🎨 Personnalisation thèmes
- 📧 Notifications email
- 📦 Export de données
- 🌍 Internationalisation
- 🎥 Support vidéo embarquée
- 🔊 Indices audio
- ⏱️ Mode chronomètre

### Améliorations techniques

- Tests unitaires/fonctionnels
- API REST pour mobile
- WebSocket pour temps réel
- Cache Redis
- Queue de messages
- CDN pour assets

## Maintenance

### Commandes utiles

```bash
# Cache
php bin/console cache:clear

# Base de données
php bin/console doctrine:schema:validate
php bin/console doctrine:migrations:diff

# Debug
php bin/console debug:router
php bin/console debug:config security

# Tests
php bin/phpunit
```

### Fichiers clés

- `config/packages/security.yaml` - Sécurité
- `config/routes.yaml` - Routes
- `.env` - Configuration environnement
- `compose.yaml` - Docker
- `migrations/` - Schéma base de données

## Conclusion

IAdventure est une application Symfony moderne, complète et prête à l'emploi pour des ateliers pédagogiques interactifs. Elle suit les meilleures pratiques Symfony, implémente une architecture solide et offre une expérience utilisateur fluide pour les enseignants et les élèves.

**Status: Production Ready ✅**

---

*Développé avec Symfony 7.3, PHP 8.3, MariaDB 10.11*
