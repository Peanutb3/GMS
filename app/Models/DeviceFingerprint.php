<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceFingerprint extends Model
{
    protected $fillable = [
        'user_id',
        'fingerprint_hash',
        'device_name',
        'user_agent',
        'ip_address',
        'last_seen_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a device fingerprint hash
     * Uses only user agent to avoid issues with changing IP addresses
     * (e.g., mobile networks, VPNs, dynamic IPs)
     */
    public static function generateFingerprint(string $userAgent, string $ipAddress): string
    {
        // Use only user agent for fingerprinting to avoid IP instability
        return hash('sha256', $userAgent);
    }

    /**
     * Check if a device is trusted for a user
     */
    public static function isTrustedDevice(int $userId, string $fingerprint): bool
    {
        return self::where('user_id', $userId)
            ->where('fingerprint_hash', $fingerprint)
            ->exists();
    }

    /**
     * Register a new trusted device
     */
    public static function registerDevice(int $userId, string $fingerprint, string $userAgent, string $ipAddress): void
    {
        self::updateOrCreate(
            [
                'user_id' => $userId,
                'fingerprint_hash' => $fingerprint,
            ],
            [
                'user_agent' => $userAgent,
                'ip_address' => $ipAddress,
                'device_name' => self::getDeviceName($userAgent),
                'last_seen_at' => now(),
            ]
        );
    }

    /**
     * Get a friendly device name from user agent
     */
    private static function getDeviceName(string $userAgent): string
    {
        if (stripos($userAgent, 'iPhone') !== false) return 'iPhone';
        if (stripos($userAgent, 'iPad') !== false) return 'iPad';
        if (stripos($userAgent, 'Android') !== false) return 'Android Device';
        if (stripos($userAgent, 'Windows') !== false) return 'Windows PC';
        if (stripos($userAgent, 'Macintosh') !== false) return 'Mac';
        if (stripos($userAgent, 'Linux') !== false) return 'Linux PC';

        return 'Unknown Device';
    }
}
