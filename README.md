# Quai antique
## *Attention !* Ce projet a été réalisé dans le cadre d'une évaluation en cours de formation. Les images utilisées sont toutes libres de droit, en revanche le contenu est totalement factice et n'existe que pour faire apparaître la structure globale de l'application.

### Prérequis :
- **XAMPP**, **Composer** et **NPM** installés sur la machine hôte
- `Symfony CLI` accessible depuis le répertoire du projet

### Installation :
- Cloner le dépôt git dans un répertoire vide
- Dans un terminal, se placer dans le répertoire du projet `cd <project_dir>`
- Lancer `composer install` pour installer toutes les bundles nécessaires à Symfony
- Une fois cette commande terminée, lancer `npm install` pour installer les modules nécessaires à Encore
- Lorsque toutes les dépendances sont installées, modifiez la variable d'environnement `DATABASE_URL` dans le fichier `.env` (et/ou `.env.local`) pour se connecter au SGBD (ici MariaDB, base de données SQL, installé avec l'utilitaire XAMPP)
- *Assurez vous que XAMPP Control Panel soit lancé et que les services Apache et MySQL soient lancés et fonctionnels*
- Appliquez les migrations : `php bin/console doctrine:migrations:migrate`
- Appliquez les fixtures pour insérer des données factices : `php bin/console doctrine:fixtures:load`
  - `Note` : `AdminFixtures` crée un utilisateur avec le rôle administrateur (`"ROLE_ADMIN"`) pour démontrer l'accès restreint au panneau d'administration (route `/admin/~`)
- Lancer le serveur Symfony : `symfony server:start`
- Lancer la compilation des bundles JS via webpack : `npm run dev`

Vous pouvez maintenant avoir un aperçu du site à l'adresse `localhost:8000`

