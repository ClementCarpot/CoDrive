# CoDrive

Comment déployer et tester l'application ?

## Prérequis

- PHP (version 7.4 ou supérieur)
- Composer
- PostgreSQL
___
## Initialisation

1. Récupérer le contenu sur votre environnement local :

        git clone https://github.com/ClementCarpot/CoDrive.git
___
2. Entrer dans le dossier du projet : 

        cd CoDrive
___
3. Mettre à jour les dépendances du projet avec Composer :

        composer update
___
4. Modifier le fichier .env pour configuer la connexion à la base de données :
(cette ligne)

        DATABASE_URL=postgresql://app:Caramelc17@localhost:5432/postgres
___
5. Créer la base de données avec Doctrine :

        php bin/console doctrine:database:create
___
6. Mettre à jour avec les migrations : 

        php bin/console doctrine:migrations:migrate
___
7. Injecter un jeu de donnée grâce à Fixture <b>(facultatif)</b>

        php bin/console doctrine:fixtures:load
___
8. Lancer le serveur local : 

        symfony server:start
___
9. Accéder à l'application via l'url :

        https://127.0.0.1:8000/
___
Pour se connecter à l'application en tant qu'admin utiliser les identifiant suivant :

        email : admin@example.com
        mot de passe : admin

