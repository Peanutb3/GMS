<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    /**
     * Boot the trait and register model events.
     */
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created');
        });

        static::updated(function ($model) {
            $model->logActivity('updated');
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted');
        });
    }

    /**
     * Log an activity for this model.
     *
     * @param string $action
     * @param string|null $description
     * @param string $status
     * @return void
     */
    public function logActivity($action, $description = null, $status = 'success')
    {
        $user = Auth::user();

        $oldValues = null;
        $newValues = null;

        if ($action === 'updated') {
            $oldValues = $this->getOriginal();
            $newValues = $this->getAttributes();

            // Remove unchanged values
            $changes = array_diff_assoc($newValues, $oldValues);
            if (empty($changes)) {
                return; // No actual changes, don't log
            }

            $oldValues = array_intersect_key($oldValues, $changes);
            $newValues = $changes;
        } elseif ($action === 'created') {
            $newValues = $this->getAttributes();
        } elseif ($action === 'deleted') {
            $oldValues = $this->getOriginal();
        }

        AuditLog::create([
            'auditable_type' => get_class($this),
            'auditable_id' => $this->id ?? null,
            'action' => $action,
            'user_id' => $user?->id,
            'staff_id' => optional($user)->staff?->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'request_method' => Request::method(),
            'request_url' => Request::fullUrl(),
            'description' => $description,
            'status' => $status,
        ]);
    }

    /**
     * Manually log a custom activity.
     *
     * @param string $action
     * @param array|null $oldValues
     * @param array|null $newValues
     * @param string|null $description
     * @param string $status
     * @return void
     */
    public static function logCustomActivity($action, $oldValues = null, $newValues = null, $description = null, $status = 'success')
    {
        $user = Auth::user();

        AuditLog::create([
            'auditable_type' => static::class,
            'auditable_id' => null,
            'action' => $action,
            'user_id' => $user?->id,
            'staff_id' => optional($user)->staff?->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'request_method' => Request::method(),
            'request_url' => Request::fullUrl(),
            'description' => $description,
            'status' => $status,
        ]);
    }
}
