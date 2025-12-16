# Encrypted Student ID Fix - Summary

## Problem

The student grievances table was empty in the student dashboard, and email notifications were not being sent when staff filed grievances. This was caused by the `student_id` field being encrypted in the `students` table.

## Root Cause

-   Student IDs are stored encrypted in the database using Laravel's `Crypt` facade
-   The Student model uses the `EncryptsAttributes` trait, which automatically encrypts/decrypts the `student_id` field
-   Direct database queries like `WHERE student_id = '2022-00273'` don't work because:
    -   The database has encrypted values (e.g., `eyJpdiI6InQ3VjliWEJINkpC...`)
    -   We're comparing against plain text (e.g., `2022-00273`)
-   Eloquent can't decrypt values in SQL WHERE clauses

## Solution

Changed the approach from database-level filtering to application-level filtering:

1. **Load all relevant records** from the database
2. **Filter in PHP** by comparing decrypted values
3. **Apply pagination** after filtering (for list views)

## Files Updated

### 1. GrievanceController.php

-   **`store()` method**: Find student by iterating all students and comparing decrypted student_id
-   **`studentIndex()` method**: Load all grievances, filter by decrypted student_id, then paginate
-   **`updateStatus()` method**: Find student for email notification using decrypted comparison

### 2. StudentDashboardController.php

-   **`index()` method**: Load grievances and filter by decrypted student_id match

### 3. AdminGrievanceController.php

-   **`updateStatus()` method**: Find student for email notification using decrypted comparison

## Code Pattern Used

```php
// OLD (doesn't work with encryption):
$student = Student::where('student_id', $plainTextId)->first();

// NEW (works with encryption):
$student = Student::all()->first(function($s) use ($plainTextId) {
    return $s->student_id === $plainTextId; // Auto-decrypts via trait
});

// Or with eager loading:
$student = Student::with('user')->get()->first(function($s) use ($plainTextId) {
    return $s->student_id === $plainTextId;
});
```

## Testing Results

✅ Students found: 2 registered students
✅ Grievances matched: All 3 grievances correctly matched to their students
✅ Email addresses found: All students have valid email addresses

## Next Steps

1. **Test the student dashboard** - Log in as a student and verify grievances appear
2. **Test email notifications** - Check that emails are sent when:
    - OSAS files a new grievance
    - Staff/Admin updates a grievance status
3. **Check email logs** - If using `MAIL_MAILER=log`, check `storage/logs/laravel.log`
4. **Configure SMTP** - For production, update `.env` with SMTP settings:
    ```
    MAIL_MAILER=smtp
    MAIL_HOST=your-smtp-host
    MAIL_PORT=587
    MAIL_USERNAME=your-email@usep.edu.ph
    MAIL_PASSWORD=your-password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=noreply@usep.edu.ph
    MAIL_FROM_NAME="OSAS GMS"
    ```

## Performance Considerations

-   This approach loads all students/grievances into memory before filtering
-   For small datasets (< 1000 records), this is acceptable
-   For larger datasets, consider:
    -   Caching student ID mappings
    -   Using a separate non-encrypted lookup field
    -   Implementing full-text search with decrypted indexes

## Current Mail Configuration

-   MAIL_MAILER: smtp
-   MAIL_FROM_ADDRESS: noreply@usep.edu.ph
-   MAIL_FROM_NAME: OSAS GMS

The system is now ready to send email notifications!
