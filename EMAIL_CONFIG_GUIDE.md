# Email Configuration Guide for School Email Addresses

## Current Setup (Development)

The system is currently using `MAIL_MAILER=log` which saves all emails to `storage/logs/laravel.log` instead of sending them.

## For Production with School Email

### Option 1: Using Gmail for School Emails (@gmail.com or Google Workspace)

1. **Enable 2-Factor Authentication** on the school Gmail account
2. **Generate an App Password**:

    - Go to: https://myaccount.google.com/apppasswords
    - Select "Mail" and "Other (Custom name)"
    - Copy the generated 16-character password

3. **Update `.env` file**:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=osas@university.edu.ph
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=osas@university.edu.ph
MAIL_FROM_NAME="OSAS - Grievance Management System"
```

### Option 2: Using School's SMTP Server

Contact your school's IT department for SMTP credentials:

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.schooldomain.edu.ph
MAIL_PORT=587  # or 465 for SSL
MAIL_USERNAME=osas@schooldomain.edu.ph
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls  # or ssl
MAIL_FROM_ADDRESS=osas@schooldomain.edu.ph
MAIL_FROM_NAME="OSAS - Grievance Management System"
```

### Option 3: Using Mailtrap (Testing)

For testing email functionality without sending real emails:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@gms.local
MAIL_FROM_NAME="GMS Test"
```

## Testing Password Reset Emails

### Development Mode (Current)

Check `storage/logs/laravel.log` for email content:

```bash
tail -f storage/logs/laravel.log
```

### Production Mode

After configuring SMTP:

```bash
php artisan tinker
> Illuminate\Support\Facades\Password::sendResetLink(['email' => 'test@school.edu.ph']);
```

## Important Notes

1. **School Email Domains**: Users with school email addresses (e.g., `@university.edu.ph`) will receive password reset emails at those addresses.

2. **Email Verification**: The system doesn't require email verification currently. If needed, enable it in `User` model:

    ```php
    class User extends Authenticatable implements MustVerifyEmail
    ```

3. **Rate Limiting**: Password reset requests are automatically rate-limited by Laravel (max 5 attempts per minute per email).

4. **Queue Jobs** (Recommended for Production):
    ```env
    QUEUE_CONNECTION=database
    ```
    Then run: `php artisan queue:work`

## Troubleshooting

### Emails not sending?

1. Check `.env` configuration
2. Run: `php artisan config:clear`
3. Check firewall/antivirus isn't blocking SMTP
4. Verify SMTP credentials with IT department
5. Check `storage/logs/laravel.log` for errors

### Gmail "Less secure app" error?

-   Use App Password instead of regular password
-   Enable 2FA first, then generate App Password

### School SMTP authentication fails?

-   Verify credentials with IT department
-   Check if SMTP requires VPN connection
-   Try different ports (587, 465, 25)
-   Try different encryption (tls, ssl, null)
