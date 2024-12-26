# Étape 1 : Utiliser une image de base officielle avec PHP et Apache
FROM php:8.1-apache

# Étape 2 : Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Étape 3 : Copier les fichiers de l'application dans le conteneur
COPY . /var/www/html

# Étape 4 : Assurer les permissions correctes
RUN chown -R www-data:www-data /var/www/html

# Étape 5 : Exposer le port 80
EXPOSE 80

# Étape 6 : Lancer Apache en mode premier plan
CMD ["apache2-foreground"]
