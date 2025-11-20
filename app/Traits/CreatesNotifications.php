<?php

namespace App\Traits;

use App\Models\Notification;

trait CreatesNotifications
{
    /**
     * Create a grievance notification
     */
    protected function notifyGrievanceSubmitted($userId, $grievanceId, $studentName)
    {
        return Notification::createNotification(
            $userId,
            'grievance',
            'New grievance submitted',
            "Student {$studentName} filed a new case",
            [
                'icon' => 'grievance',
                'color' => 'red',
                'link' => route('admin.grievances.show', $grievanceId),
                'related_id' => $grievanceId,
                'related_type' => 'App\Models\Grievance'
            ]
        );
    }

    /**
     * Create a grievance resolved notification
     */
    protected function notifyGrievanceResolved($userId, $grievanceId, $caseId)
    {
        return Notification::createNotification(
            $userId,
            'resolved',
            "{$caseId} resolved",
            "Case has been successfully resolved and closed",
            [
                'icon' => 'resolved',
                'color' => 'green',
                'link' => route('admin.grievances.show', $grievanceId),
                'related_id' => $grievanceId,
                'related_type' => 'App\Models\Grievance'
            ]
        );
    }

    /**
     * Create a grievance status updated notification
     */
    protected function notifyGrievanceStatusUpdated($userId, $grievanceId, $caseId, $newStatus)
    {
        return Notification::createNotification(
            $userId,
            'message',
            "{$caseId} status updated",
            "Case status changed to: {$newStatus}",
            [
                'icon' => 'message',
                'color' => 'blue',
                'link' => route('admin.grievances.show', $grievanceId),
                'related_id' => $grievanceId,
                'related_type' => 'App\Models\Grievance'
            ]
        );
    }

    /**
     * Create a good moral request notification
     */
    protected function notifyGoodMoralRequest($userId, $requestId, $studentName)
    {
        return Notification::createNotification(
            $userId,
            'request',
            'New good moral certificate request',
            "Request submitted by {$studentName}",
            [
                'icon' => 'request',
                'color' => 'yellow',
                'link' => route('admin.requests.good-moral'),
                'related_id' => $requestId,
                'related_type' => 'App\Models\GoodMoralRequest'
            ]
        );
    }

    /**
     * Create a good moral approved notification
     */
    protected function notifyGoodMoralApproved($userId, $requestId)
    {
        return Notification::createNotification(
            $userId,
            'resolved',
            'Good moral certificate approved',
            "Your request has been approved and is ready for pickup",
            [
                'icon' => 'resolved',
                'color' => 'green',
                'link' => route('student.requests'),
                'related_id' => $requestId,
                'related_type' => 'App\Models\GoodMoralRequest'
            ]
        );
    }

    /**
     * Create a hearing scheduled notification
     */
    protected function notifyHearingScheduled($userId, $grievanceId, $caseId, $date, $time)
    {
        return Notification::createNotification(
            $userId,
            'scheduled',
            "Hearing scheduled for {$caseId}",
            "Meeting set for {$date} at {$time}",
            [
                'icon' => 'scheduled',
                'color' => 'blue',
                'link' => route('admin.grievances.show', $grievanceId),
                'related_id' => $grievanceId,
                'related_type' => 'App\Models\Grievance'
            ]
        );
    }

    /**
     * Create a general message notification
     */
    protected function notifyMessage($userId, $title, $message, $link = null)
    {
        return Notification::createNotification(
            $userId,
            'message',
            $title,
            $message,
            [
                'icon' => 'message',
                'color' => 'purple',
                'link' => $link
            ]
        );
    }

    /**
     * Notify all admins
     */
    protected function notifyAllAdmins($type, $title, $message, $options = [])
    {
        $admins = \App\Models\User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            Notification::createNotification(
                $admin->id,
                $type,
                $title,
                $message,
                $options
            );
        }
    }

    /**
     * Notify all staff
     */
    protected function notifyAllStaff($type, $title, $message, $options = [])
    {
        $staff = \App\Models\User::where('role', 'staff')->get();
        
        foreach ($staff as $staffMember) {
            Notification::createNotification(
                $staffMember->id,
                $type,
                $title,
                $message,
                $options
            );
        }
    }
}
