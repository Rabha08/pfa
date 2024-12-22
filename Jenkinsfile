pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                // Commandes pour compiler votre code
                sh 'make build' 
            }
        }
        stage('Build Docker Image') {
            steps {
                // Commande pour construire l'image Docker
                sh 'docker build -t your_image_name .'
            }
        }
        stage('Push Docker Image') {
            steps {
                // Commande pour pousser l'image vers Dockerhub
                withCredentials([string(credentialsId: 'dockerhub-credentials', variable: 'DOCKERHUB_PASSWORD')]) {
                    sh 'docker login -u your_dockerhub_username -p $DOCKERHUB_PASSWORD'
                    sh 'docker tag your_image_name your_dockerhub_username/your_image_name'
                    sh 'docker push your_dockerhub_username/your_image_name'
                }
            }
        }
        stage('Deploy') {
            steps {
                // Commandes de déploiement sur un serveur distant
                sshagent(['ssh-credentials-id']) {
                    sh """
                    ssh user@remote_server 'docker pull your_dockerhub_username/your_image_name'
                    ssh user@remote_server 'docker stop current_container || true'
                    ssh user@remote_server 'docker rm current_container || true'
                    ssh user@remote_server 'docker run -d --name current_container -p 80:80 your_dockerhub_username/your_image_name'
                    """
                }
            }
        }
    }
}
