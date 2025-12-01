<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class LogPageViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log authenticated user actions
        if (Auth::check()) {
            $user = Auth::user();

            // Define which routes to log
            $loggedRoutes = [
                'admin.students.index',
                'admin.students.show',
                'admin.students.edit',
                'admin.staff.index',
                'admin.staff.show',
                'admin.staff.edit',
                'admin.grievances.index',
                'admin.grievances.show',
                'admin.requests.good-moral',
                'admin.requests.safe-loan',
                'admin.audit-logs',
                'admin.settings',
            ];

            $routeName = $request->route()?->getName();

            if (in_array($routeName, $loggedRoutes)) {
                AuditLog::create([
                    'auditable_type' => 'App\\Models\\User',
                    'auditable_id' => $user->id,
                    'action' => 'page_view',
                    'user_id' => $user->id,
                    'staff_id' => optional($user->staff)->id,
                    'old_values' => null,
                    'new_values' => ['route' => $routeName],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'request_method' => $request->method(),
                    'request_url' => $request->fullUrl(),
                    'description' => "Viewed: {$routeName}",
                    'status' => 'success',
                ]);
            }
        }

        return $response;
    }
}
