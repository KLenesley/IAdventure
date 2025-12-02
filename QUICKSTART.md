# IAdventure - Guide de démarrage rapide

## Installation en 5 minutes

### 1. Cloner et installer
```bash
git clone https://github.com/KLenesley/IAdventure.git
cd IAdventure
composer install
```

### 2. Démarrer la base de données
```bash
docker compose up -d database
```

### 3. Créer et initialiser la base
```bash
# Attendre que la base soit prête (environ 10 secondes)
sleep 10

# Créer le schéma
php bin/console doctrine:migrations:migrate --no-interaction

# Charger les données de test
php bin/console doctrine:fixtures:load --no-interaction
```

### 4. Démarrer le serveur
```bash
symfony server:start -d
# OU
php -S localhost:8000 -t public
```

### 5. Accéder à l'application
- **Interface enseignant** : http://localhost:8000/teacher/game
  - Email: `prof@gmail.com`
  - Mot de passe: `prof`

- **Interface admin** : http://localhost:8000/user
  - Email: `admin@gmail.com`
  - Mot de passe: `admin`

## Créer votre premier jeu

1. Connectez-vous avec le compte professeur
2. Cliquez sur "Créer un nouveau jeu"
3. Remplissez le formulaire :
   - Titre : "Découverte de l'IA"
   - Message de bienvenue : "Bienvenue dans l'aventure de l'intelligence artificielle !"
4. Cliquez sur "Créer"
5. Dans la page du jeu, cliquez sur "Gérer les énigmes"
6. Ajoutez votre première énigme :
   - Titre : "Qu'est-ce que l'IA ?"
   - Instruction : "Trouvez le code secret qui définit l'IA"
   - Code secret : "INTELLIGENCE"
   - Ordre : 1
   - Type : QCM
7. Enregistrez l'énigme
8. Cliquez sur "Tester le jeu" pour jouer

## Faire jouer les élèves

1. Depuis la page du jeu, copiez le lien "Tester le jeu"
2. Partagez ce lien avec vos élèves
3. Les élèves créent leur équipe (pas de compte nécessaire)
4. Ils résolvent les énigmes en entrant les codes secrets
5. Suivez leur progression en temps réel depuis le tableau de bord

## Commandes utiles

```bash
# Vider le cache
php bin/console cache:clear

# Créer un utilisateur
php bin/console app:create-user

# Voir tous les utilisateurs
php bin/console doctrine:query:sql "SELECT email, roles FROM tbl_user"

# Voir tous les jeux
php bin/console doctrine:query:sql "SELECT id, title FROM tbl_game"

# Arrêter le serveur Symfony
symfony server:stop

# Arrêter la base de données
docker compose down
```

## Structure rapide

- **Entités** : `src/Entity/` - 10 entités (User, Game, Enigma, etc.)
- **Contrôleurs** : `src/Controller/` - 5 contrôleurs principaux
- **Templates** : `templates/` - Toutes les vues
- **Formulaires** : `src/Form/` - Formulaires de création/édition
- **Configuration** : `config/` - Configuration Symfony

## Aide et support

En cas de problème :
1. Vérifiez que Docker est lancé
2. Vérifiez que la base de données est démarrée : `docker compose ps`
3. Vérifiez les logs : `tail -f var/log/dev.log`
4. Vérifiez l'environnement : `php bin/console about`

## Aller plus loin

- Ajoutez des images aux énigmes via les Thumbnails
- Créez plusieurs types d'énigmes
- Configurez les Settings pour personnaliser le jeu
- Consultez le README.md complet pour plus de détails

---

Bon jeu ! 🎮
