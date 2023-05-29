# CoDrive

Comment déployer et tester l'application ?

## Prérequis

- PHP (version 7.4 ou supérieur)
- Composer
- PostgreSQL

## Initialisation

1. Récupérer le contenu sur votre environnement local :

        git clone https://github.com/ClementCarpot/CoDrive.git

2. Entrer dans le dossier du projet : 

        cd CoDrive

3. Mettre à jour les dépendances du projet avec Composer :

        composer update

4. Modifier le fichier .env pour configuer la connexion à la base de données :
(cette ligne)

        DATABASE_URL=postgresql://app:Caramelc17@localhost:5432/postgres

5. Créer la base de données avec Doctrine :

        php bin/console doctrine:database:create

6. Mettre à jour avec les migrations : 

        php bin/console doctrine:migrations:migrate

7. Injecter un jeu de donnée grâce à Fixture <b>(facultatif)</b>

        php bin/console doctrine:fixtures:load

8. Lancer le serveur local : 

        symfony server:start

9. Accéder à l'application via l'url :

        https://127.0.0.1:8000/

Pour se connecter à l'application en tant qu'admin utiliser les identifiant suivant :

        email : admin@example.com
        mot de passe : admin

