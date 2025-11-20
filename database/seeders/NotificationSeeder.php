<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        // Get all users
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please seed users first.');
            return;
        }

        foreach ($users as $user) {
            // Create sample notifications for each user
            Notification::createNotification(
                $user->id,
                'grievance',
                'New grievance submitted',
                'Student filed a new case regarding academic concerns',
                [
                    'icon' => 'grievance',
                    'color' => 'red',
                    'link' => route('admin.grievances')
                ]
            );

            Notification::createNotification(
                $user->id,
                'resolved',
                'CASE-2025-003 resolved',
                'Case has been successfully resolved and closed',
                [
                    'icon' => 'resolved',
                    'color' => 'green',
                    'link' => route('admin.grievances')
                ]
            );

            // Mark this one as read
            $readNotif = Notification::createNotification(
                $user->id,
                'scheduled',
                'Hearing scheduled for CASE-2025-001',
                'Meeting set for November 25, 2025 at 2:00 PM',
                [
                    'icon' => 'scheduled',
                    'color' => 'blue',
                    'link' => route('admin.grievances')
                ]
            );
            $readNotif->markAsRead();

            // Another read notification
            $messageNotif = Notification::createNotification(
                $user->id,
                'message',
                'New message from Guidance Office',
                'Please review the updated student handbook',
                [
                    'icon' => 'message',
                    'color' => 'purple',
                    'link' => '#'
                ]
            );
            $messageNotif->markAsRead();
        }

        $this->command->info('Notifications seeded successfully!');
    }
}
