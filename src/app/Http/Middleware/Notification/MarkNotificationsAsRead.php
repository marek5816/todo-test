<?php

namespace App\Http\Middleware\Notification;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarkNotificationsAsRead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $user = $request->user();
        if ($user) {
            $notifications = auth()->user()->notifications()
                ->orderByRaw('ISNULL(read_at) DESC')
                ->orderBy('read_at', 'ASC')
                ->paginate(10);

            foreach (clone $notifications as $notification) {
                if (is_null($notification->read_at)) {
                    $notification->markAsRead();
                }
            }
        }
    }
}
