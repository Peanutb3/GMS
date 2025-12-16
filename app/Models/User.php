<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin', 'staff', or 'student'
        'otp_expires_at',
        'trusted_devices',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'trusted_devices' => 'array',
        'password' => 'hashed',
    ];

    /**
     * Check if OTP is required based on role and device
     */
    public function requiresOtp($deviceFingerprint = null): bool
    {
        // Admin: OTP required every 1 month OR new device
        if ($this->role === 'admin') {
            if (!$this->otp_expires_at || now()->greaterThan($this->otp_expires_at)) {
                return true;
            }
            // Check if new device
            if ($deviceFingerprint && !$this->isTrustedDevice($deviceFingerprint)) {
                return true;
            }
            return false;
        }

        // All other roles (staff, student, osas_gmc, osas_du, etc.):
        // OTP required only on first login or new device
        // First time login (never verified OTP)
        if (!$this->otp_expires_at) {
            return true;
        }
        // Check if new device
        if ($deviceFingerprint && !$this->isTrustedDevice($deviceFingerprint)) {
            return true;
        }
        return false;
    }

    /**
     * Check if device is trusted
     */
    public function isTrustedDevice($deviceFingerprint): bool
    {
        return DeviceFingerprint::isTrustedDevice($this->id, $deviceFingerprint);
    }

    /**
     * Add device to trusted list
     */
    public function trustDevice($deviceFingerprint, $userAgent = null, $ipAddress = null): void
    {
        // Use provided values or fall back to current request
        $request = request();
        DeviceFingerprint::registerDevice(
            $this->id,
            $deviceFingerprint,
            $userAgent ?? $request->userAgent() ?? 'Unknown',
            $ipAddress ?? $request->ip() ?? '0.0.0.0'
        );
    }

    /**
     * Set OTP expiration based on role
     */
    public function setOtpExpiration(): void
    {
        if ($this->role === 'admin') {
            // Admin: 1 month
            $this->otp_expires_at = now()->addMonth();
        } else {
            // Staff & Students: indefinite (only reset on new device)
            $this->otp_expires_at = now()->addYears(10);
        }
        $this->save();
    }

    // ✅ Relationships
    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'user_id', 'id');
    }

    public function deviceFingerprints()
    {
        return $this->hasMany(DeviceFingerprint::class);
    }
}
