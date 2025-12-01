# 🔒 Security Quick Reference Card

## New Password Requirements

```
✓ Minimum 8 characters
✓ At least one UPPERCASE letter (A-Z)
✓ At least one lowercase letter (a-z)
✓ At least one number (0-9)
✓ At least one special character (@$!%*#?&)

Examples:
  ✓ Welcome123!
  ✓ School@2025
  ✗ password (too simple)
  ✗ Pass123 (missing special char & uppercase)
```

## Account Lockout Policy

```
5 failed login attempts = 30 minute lockout

To unlock manually:
  php artisan test:security unlock
```

## File Upload Restrictions

```
Profile Photos:
  ✓ Types: JPG, JPEG, PNG only
  ✓ Max Size: 2MB
  ✓ Max Dimensions: 2000x2000px
  ✗ GIF, SVG, PDF not allowed
```

## Session Security

```
Timeout: 2 hours of inactivity
Security: HTTPS-only cookies
Protection: CSRF + XSS prevention
```

## Testing Commands

```bash
# Test password validation rules
php artisan test:security password

# Check locked accounts
php artisan test:security lockout

# Unlock an account
php artisan test:security unlock

# View security headers
php artisan test:security headers

# Send test email
Visit: /settings → Email Configuration Test
```

## Security Headers (Auto-Applied)

```
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: geolocation=(), microphone=(), camera=()
Content-Security-Policy: [configured]
```

## Production Checklist

```bash
# Before deployment:
□ Set APP_ENV=production
□ Set APP_DEBUG=false
□ Configure SMTP email
□ Install SSL certificate
□ Set SESSION_SECURE_COOKIE=true
□ Run: php artisan config:cache
□ Run: php artisan route:cache
□ Set file permissions (chmod 600 .env)
□ Test forgot password flow
□ Test account lockout
□ Verify security headers
```

## Audit Logs

All security events are logged to `audit_logs` table:

-   ✓ Login success/failure
-   ✓ Account lockouts
-   ✓ Password resets
-   ✓ User actions

Query recent failed logins:

```sql
SELECT * FROM audit_logs
WHERE action = 'login_failed'
ORDER BY created_at DESC
LIMIT 10;
```

## Emergency Contacts

```
Server Issues: [IT Department]
Security Concerns: [Security Officer]
Database: [DBA Name]
```

## Quick Links

-   Full Guide: SECURITY_IMPLEMENTATION_SUMMARY.md
-   Deployment: PRODUCTION_DEPLOYMENT.md
-   Email Setup: EMAIL_CONFIG_GUIDE.md
-   Recommendations: SECURITY_RECOMMENDATIONS.md
