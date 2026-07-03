# Despliegue de Nanki

## Servidor Remoto
- **IP:** 38.250.161.113
- **Usuario:** root
- **Ruta:** /var/www/nanki/
- **Dominio:** nankiperu.com

## Pasos de Despliegue

### 1. En el Servidor Remoto (SSH)

```bash
cd /var/www/nanki
git clone https://github.com/qipuh/nanki.git .
```

### 2. Instalar Dependencias

```bash
composer install --no-dev
npm install
npm run build
```

### 3. Generar clave de aplicación

```bash
php artisan key:generate
```

### 4. Migraciones y seeders (si es necesario)

```bash
php artisan migrate --force
php artisan db:seed
```

### 5. Configurar Permisos

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data /var/www/nanki
```

### 6. Configurar Apache

Crear archivo: `/etc/apache2/sites-available/nankiperu.com.conf`

```apache
<VirtualHost *:80>
    ServerName nankiperu.com
    ServerAlias www.nankiperu.com
    DocumentRoot /var/www/nanki/public

    <Directory /var/www/nanki/public>
        AllowOverride All
        Require all granted
        
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^ index.php [QSA,L]
        </IfModule>
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/nankiperu_error.log
    CustomLog ${APACHE_LOG_DIR}/nankiperu_access.log combined
</VirtualHost>

<VirtualHost *:443>
    ServerName nankiperu.com
    ServerAlias www.nankiperu.com
    DocumentRoot /var/www/nanki/public

    SSLEngine on
    SSLCertificateFile /path/to/cert.crt
    SSLCertificateKeyFile /path/to/key.key

    <Directory /var/www/nanki/public>
        AllowOverride All
        Require all granted
        
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^ index.php [QSA,L]
        </IfModule>
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/nankiperu_error.log
    CustomLog ${APACHE_LOG_DIR}/nankiperu_access.log combined
</VirtualHost>
```

```bash
a2ensite nankiperu.com
a2dissite 000-default (si es necesario)
apache2ctl configtest
systemctl restart apache2
```

### 7. Crear archivo .env en el servidor

Copiar `.env.example` a `.env` y configurar variables:
- `APP_URL=https://nankiperu.com`
- `APP_DEBUG=false`
- Base de datos (si no usa SQLite)
- Correo
- etc.

### 8. Verificar HTTPS

Usar Let's Encrypt:
```bash
apt install certbot python3-certbot-apache
certbot --apache -d nankiperu.com -d www.nankiperu.com
```

## Variables de Entorno Críticas

```
APP_NAME=Nanki
APP_ENV=production
APP_DEBUG=false
APP_URL=https://nankiperu.com
LOG_LEVEL=info
```

## Notas Importantes

- No tocar configuraciones de otros dominios
- Hacer backup de datos antes de desplegar
- Cambiar la contraseña del servidor después de usarla
- Configurar SSL certificado válido
