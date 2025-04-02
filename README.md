# Funnels Application

## Requisitos
- Docker
- Docker Compose
- Un VPS con Ubuntu/Debian
- Dominio configurado (chatsfunnels.es)

## Configuración Inicial

1. Clonar el repositorio:
```bash
git clone <url-del-repositorio>
cd funnels
```

2. Configurar variables de entorno:
```bash
cp .env.example .env
# Editar .env con las credenciales correctas
```

3. Crear directorio para certificados SSL:
```bash
mkdir -p docker/nginx/ssl
```

4. Obtener certificados SSL (usando Certbot):
```bash
sudo certbot certonly --standalone -d chatsfunnels.es -d www.chatsfunnels.es
sudo cp /etc/letsencrypt/live/chatsfunnels.es/fullchain.pem docker/nginx/ssl/chatsfunnels.es.crt
sudo cp /etc/letsencrypt/live/chatsfunnels.es/privkey.pem docker/nginx/ssl/chatsfunnels.es.key
```

## Despliegue

1. Construir y levantar los contenedores:
```bash
docker-compose up -d --build
```

2. Instalar dependencias y configurar Laravel:
```bash
docker-compose exec app composer install --optimize-autoloader --no-dev
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan storage:link
```

3. Configurar permisos:
```bash
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

## Acceso
- Aplicación: https://chatsfunnels.es
- phpMyAdmin: https://chatsfunnels.es/phpmyadmin

## Mantenimiento

- Visualizar logs:
```bash
docker-compose logs -f
```

- Reiniciar servicios:
```bash
docker-compose restart
```

- Actualizar la aplicación:
```bash
git pull
docker-compose up -d --build
docker-compose exec app composer install --optimize-autoloader --no-dev
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
```
