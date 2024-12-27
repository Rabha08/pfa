pipeline {
    agent {
        docker {
            image 'php:7.4-fpm'
            args '-v /var/run/docker.sock:/var/run/docker.sock'
        }
    }
    stages {
        stage('Cloner le projet') {
            steps {
                git 'https://github.com/Rabha08/pfa.git'
            }
        }
        stage('Verifier Docker et Docker Compose') {
            steps {
                script {
                    sh 'docker --version'
                    sh 'docker-compose --version'
                }
            }
        }
        stage('Construire l\'image Docker') {
            steps {
                script {
                    sh 'docker-compose build'
                }
            }
        }
        stage('Exécuter les tests') {
            steps {
                script {
                    sh 'docker-compose run --rm app php bin/phpunit'
                }
            }
        }
        stage('Déployer l\'application') {
            steps {
                script {
                    sh 'docker-compose up -d'
                }
            }
        }
    }
}


