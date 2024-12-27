# image de base PHP
FROM php:7.4-cli

#  répertoire de travail
WORKDIR /app

# Copie des fichiers du projet dans le conteneur
COPY . /app

# Installation des dépendances avec Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer install

# Exposer le port 80
EXPOSE 80

# Commande pour démarrer l'application
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
