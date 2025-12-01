# 🚀 Production Deployment Checklist

## Pre-Deployment Security Configuration

### 1. Environment Variables (.env)

```env
# CRITICAL: Set to production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Generate new key: php artisan key:generate
APP_KEY=base64:YourGeneratedKeyHere

# Session Security (CRITICAL for HTTPS)
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=strict
SESSION_LIFETIME=120

# Database (Use strong password)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gms_production
DB_USERNAME=gms_user
DB_PASSWORD=Your-Very-Strong-Password-Here

# Mail Configuration (For password reset)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-school-email@school.edu.ph
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@school.edu.ph
MAIL_FROM_NAME="GMS System"

# Password Hashing
BCRYPT_ROUNDS=12
```

### 2. Server Configuration

#### Apache (.htaccess already configured)

```apache
# Force HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Disable directory listing
Options -Indexes

# Hide sensitive files
<FilesMatch "^\.env">
    Order allow,deny
    Deny from all
</FilesMatch>
```

#### Nginx (if using)

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com;

    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;

    # Security headers (redundant with middleware, but good practice)
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;

    root /var/www/gms/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 3. File Permissions

```bash
# Set proper ownership
chown -R www-data:www-data /var/www/gms

# Set directory permissions
find /var/www/gms -type d -exec chmod 755 {} \;

# Set file permissions
find /var/www/gms -type f -exec chmod 644 {} \;

# Storage and cache need write access
chmod -R 775 /var/www/gms/storage
chmod -R 775 /var/www/gms/bootstrap/cache

# CRITICAL: Protect .env file
chmod 600 /var/www/gms/.env
```

### 4. Database Setup

```bash
# Run migrations
php artisan migrate --force

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 5. SSL Certificate

#### Option A: Let's Encrypt (Free)

```bash
# Install certbot
sudo apt install certbot python3-certbot-apache

# Generate certificate
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com

# Auto-renewal (already configured by certbot)
sudo certbot renew --dry-run
```

#### Option B: Paid SSL

-   Purchase from SSL provider
-   Install certificate on server
-   Configure in Apache/Nginx

### 6. Email Configuration (School Email)

#### Gmail/Google Workspace

1. Enable 2FA on your Google account
2. Generate App Password:
    - Go to: https://myaccount.google.com/apppasswords
    - Select app: "Mail"
    - Select device: "Other (Custom name)" → "GMS System"
    - Copy the 16-character password
3. Update .env:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@school.edu.ph
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
```

#### School SMTP Server

Contact your IT department for:

-   SMTP Host
-   SMTP Port
-   Authentication credentials
-   Encryption type (TLS/SSL)

### 7. Firewall Configuration

```bash
# Allow HTTP and HTTPS only
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw allow 22/tcp  # SSH (use custom port for better security)
sudo ufw enable

# Block unnecessary ports
sudo ufw deny 3306/tcp  # MySQL (only allow localhost)
```

### 8. Backup Strategy

#### Database Backup (Daily)

```bash
#!/bin/bash
# /var/scripts/backup-db.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/gms"
DB_NAME="gms_production"
DB_USER="gms_user"
DB_PASS="Your-Password"

mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Encrypt backup
openssl enc -aes-256-cbc -salt -in $BACKUP_DIR/db_$DATE.sql.gz -out $BACKUP_DIR/db_$DATE.sql.gz.enc -k "YourEncryptionKey"
rm $BACKUP_DIR/db_$DATE.sql.gz

# Keep only last 30 days
find $BACKUP_DIR -type f -mtime +30 -delete
```

Add to crontab:

```bash
0 2 * * * /var/scripts/backup-db.sh
```

#### Files Backup (Weekly)

```bash
#!/bin/bash
# /var/scripts/backup-files.sh

DATE=$(date +%Y%m%d)
BACKUP_DIR="/var/backups/gms"
APP_DIR="/var/www/gms"

tar -czf $BACKUP_DIR/files_$DATE.tar.gz $APP_DIR/storage/app/public

# Keep only last 8 weeks
find $BACKUP_DIR -name "files_*.tar.gz" -mtime +56 -delete
```

### 9. Monitoring & Logging

#### Log Rotation

```bash
# /etc/logrotate.d/gms

/var/www/gms/storage/logs/*.log {
    daily
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
    postrotate
        php /var/www/gms/artisan config:cache
    endscript
}
```

#### Failed Login Monitoring

```bash
# Monitor failed logins
tail -f /var/www/gms/storage/logs/laravel.log | grep login_failed
```

### 10. Security Testing

Before going live:

-   [ ] Test password reset flow
-   [ ] Test account lockout (5 failed attempts)
-   [ ] Verify HTTPS is enforced
-   [ ] Check security headers with: https://securityheaders.com
-   [ ] Test file upload with large/invalid files
-   [ ] Verify debug mode is OFF
-   [ ] Test from different browsers
-   [ ] Run SQL injection tests
-   [ ] Test XSS protection
-   [ ] Verify CSRF protection on all forms

## Post-Deployment Monitoring

### Daily Checks

-   Review audit logs for suspicious activity
-   Check failed login attempts
-   Monitor disk space
-   Verify backups completed

### Weekly Checks

-   Review error logs
-   Update dependencies: `composer update`
-   Check SSL certificate expiry
-   Review user permissions

### Monthly Checks

-   Full security audit
-   Password policy review
-   Update Laravel: `php artisan optimize`
-   Review and clean old logs
-   Test backup restoration

## Emergency Response Plan

### If Compromised:

1. **Immediate Actions:**

    - Take site offline
    - Change all passwords (.env, database, email)
    - Regenerate APP_KEY: `php artisan key:generate`
    - Review audit logs for breach entry point
    - Check for malware: `grep -r "eval(" /var/www/gms`

2. **Recovery:**

    - Restore from clean backup
    - Update all dependencies
    - Review all user accounts
    - Force password reset for all users
    - Notify affected users

3. **Prevention:**
    - Implement IP whitelisting for admin panel
    - Enable 2FA for all admins
    - Review and strengthen security policies

## Contact Information

-   **Server Admin:** [Your Name] - [email]
-   **Database Admin:** [Name] - [email]
-   **Security Officer:** [Name] - [email]
-   **Emergency Contact:** [Phone Number]

## Additional Resources

-   Laravel Security Docs: https://laravel.com/docs/11.x/security
-   OWASP Top 10: https://owasp.org/www-project-top-ten/
-   SSL Test: https://www.ssllabs.com/ssltest/
-   Security Headers: https://securityheaders.com/
