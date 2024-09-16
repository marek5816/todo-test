<?php

namespace App\Traits;

use App\Models\Auth\User;
use App\Notifications\TaskNotification;
use Illuminate\Support\Facades\Auth;

trait Route
{
    public function redirectWithQuerySuccess(string $route, string $message) {
        $previousUrl = url()->previous();
        $targetRoute = route($route);
        if (parse_url($previousUrl, PHP_URL_PATH) === parse_url($targetRoute, PHP_URL_PATH)) {
            return redirect()->back()
                ->with('success', $message);
        } else {
            return redirect()->to($targetRoute)
                ->with('success', $message);
        }
    }
}
