<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FollowsController extends Controller
{
    public function store(User $user) {
        auth()->user()->following()->toggle($user->profile);

        $notes = Note::where('user_id', $user->id)->latest()->paginate(5);
        return Inertia::render('Notes/ShowProfile', [
            'user'=> fn() => auth()->user(),
            'notes' => fn () => $notes,
            'viewed_user' => fn () => $user->refresh(),
            'followers' => fn () => $user->profile->followers,
        ]);
    }
}
