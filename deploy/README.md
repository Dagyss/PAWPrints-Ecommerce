# MATCHMAKING deploy

## Para el redeploy

## Luego de realizar los cambios que necesitamos en el código:

## Regenerar la imagen de docker desde la raiz del repo con:

docker build -t gcr.io/paw-print-app-paw/php-app:<NOMBRE-TAG> -f deploy/app/Dockerfile .

## Pushear la nueva imagen de docker con:

docker push gcr.io/paw-print-app-paw/php-app:<NOMBRE-TAG>

## Luego en el deployment deploy/kubernetes/nginx-php-deployment.yaml, modificar el tag de la imagen:

cambiar esto:

image: gcr.io/matchmaking-app-paw/php-app:<NOMBRE-ANTERIOR-TAG>    
por esto:

image: gcr.io/matchmaking-app-paw/php-app:<NOMBRE-NUEVO-TAG>

## Luego aplicamos el nuevo deployment desde la raiz del repo con:

kubectl apply -f deploy/kubernetes/nginx-php-deployment.yaml

## Podemos ver los pods running con:

kubectl get pods

## Como obtener los servicios y la ip púplica para el acceso (Buscar nginx con EXTERNAL-IP):

kubectl get svc


## Aplicar todos los deployments:

kubectl apply -f deploy/kubernetes/secret.yaml
kubectl apply -f deploy/kubernetes/namespace.yaml
kubectl apply -f deploy/kubernetes/configmap-env.yaml
kubectl apply -f deploy/kubernetes/mysql-pvc.yaml
kubectl apply -f deploy/kubernetes/mysql-deployment.yaml
kubectl apply -f deploy/kubernetes/mysql-service.yaml
kubectl apply -f deploy/kubernetes/web-deployment.yaml
kubectl apply -f deploy/kubernetes/nginx-service.yaml

## Ver los sercicios corriendo:

kubectl get pods -n paw-print
o
kubectl get all -n paw-print

## Ver logs 

kubectl logs deployment/mysql -n paw-print
kubectl logs deployment/web -c php -n paw-print
kubectl logs deployment/web -c nginx -n paw-print

## Restart de servicios
Para el servicio web
kubectl rollout restart deployment web -n paw-print

Para la base de datos
kubectl rollout restart deployment mysql -n paw-print


## Ingresar a un contenedor:
kubectl exec -it -n <POD-NAME> -c php -- /bin/sh

Una vez dentro podemos ejecutar el script para cargar la base de datos

php src/Deploy_database/insert_demo_data.php