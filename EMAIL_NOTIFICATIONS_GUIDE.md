# Email Notifications Setup Guide

## Overview

The OSAS-GMC system includes email notifications for important actions such as:

-   Request submissions (Good Moral & Safe Loan)
-   Request completions
-   Grievance status updates

## Configuration

### 1. Environment Setup

Add the following to your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Gmail App Password (if using Gmail)

1. Go to Google Account Settings → Security
2. Enable 2-Step Verification
3. Generate App Password for "Mail"
4. Use the generated password as `MAIL_PASSWORD`

### 3. Testing

Change `MAIL_MAILER` to `log` for testing:

```env
MAIL_MAILER=log
```

Emails will be written to `storage/logs/laravel.log`

## Implemented Notifications

### Request Submitted

Triggered when a student submits a Good Moral or Safe Loan request.

-   Location: `app/Notifications/RequestSubmittedNotification.php`
-   Usage: Send when request is created

### Request Completed

Triggered when OSAS staff marks a request as completed.

-   Location: `app/Notifications/RequestCompletedNotification.php`
-   Usage: Send when OR number is entered

### Grievance Status Update

Triggered when grievance status changes.

-   Location: `app/Notifications/GrievanceStatusUpdateNotification.php`
-   Usage: Send when status is updated by staff

## Integration Examples

### In Good Moral Controller:

```php
use App\Notifications\RequestSubmittedNotification;
use App\Models\User;

// After creating request
$user = User::where('email', $request->email)->first();
if ($user) {
    $user->notify(new RequestSubmittedNotification('Good Moral', $goodMoral->reference_no));
}
```

### In Staff Request Controller:

```php
use App\Notifications\RequestCompletedNotification;

// When OR number is entered
$user = User::where('email', $request->email)->first();
if ($user) {
    $url = route('good-moral.certificate', $request->id);
    $user->notify(new RequestCompletedNotification('Good Moral', $request->reference_no, $url));
}
```

### In Grievance Controller:

```php
use App\Notifications\GrievanceStatusUpdateNotification;

// When status is updated
$student = $grievance->student;
if ($student && $student->user) {
    $student->user->notify(new GrievanceStatusUpdateNotification(
        $grievance->case_id,
        $newStatus,
        'Your grievance has been updated by staff.'
    ));
}
```

## Queue Configuration (Optional but Recommended)

For better performance, use queues:

1. Set up queue driver in `.env`:

```env
QUEUE_CONNECTION=database
```

2. Run migrations:

```bash
php artisan queue:table
php artisan migrate
```

3. Start queue worker:

```bash
php artisan queue:work
```

## Email Verification

Email verification is already implemented and is **optional**:

-   Users can log in immediately after signup
-   Verification banner appears in profile when email is unverified
-   Users can resend verification email from their profile
-   To verify: Click link in email sent during registration

## Troubleshooting

### Emails not sending

1. Check `.env` configuration
2. Verify firewall/port access
3. Check `storage/logs/laravel.log` for errors
4. Test with `MAIL_MAILER=log` first

### Gmail not working

-   Ensure 2FA is enabled
-   Use App Password, not regular password
-   Check "Less secure app access" (deprecated, use App Password)

## Notes

-   All notification classes use Laravel's Queueable trait for queue support
-   Notifications are sent using the user's email from the database
-   Custom notification views can be created if needed
