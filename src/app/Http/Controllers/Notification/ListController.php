<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Todo\TodoCategory;
use App\Models\Todo\TodoTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function list(Request $request)
    {
        $notifications = auth()->user()->notifications()
            ->orderByRaw('ISNULL(read_at) DESC')
            ->orderBy('read_at', 'ASC')
            ->paginate(10);

        return view('notification.list', compact('notifications'));
    }
}
