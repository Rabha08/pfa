pipeline {
    agent any
    stages {
        stage('Cloner le projet') {
            steps {
                // Cloner le projet depuis GitHub
                git 'https://github.com/rabha02/symfony-projet.git'
            }
        }
        stage("Verifier Docker et Docker Compose") {
            steps {
                script {
                    sh 'docker --version'
                    sh 'docker-compose --version'
                }
            }
        }
    }
}

