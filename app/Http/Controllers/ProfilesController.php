<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name)
    {
        if(auth()->user()->name == $name) {
            return Redirect::route('notes.myIndex');
        }
        $user = User::where('name', $name)->first();
        if($user){
            $notes = Note::where('user_id', $user->id)->latest()->paginate(5);
            return Inertia::render('Notes/ShowProfile', ['user' => Auth::user(), 'notes'=>$notes, 'viewed_user' => $user, 'followers' => $user->profile->followers]);
        }else{
            return Inertia::render('Notfound');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $profile = new Profile();
        $profile->title = $request->proTitle;
        $profile->description = $request->proDescription;
        $profile->user_id = $request->user_id;
        $profile->save();

        return Redirect::route('notes.myIndex');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->title.' '.$request->description);
        $profile = Profile::find($id);
        $profile->title = $request->proTitle;
        $profile->description = $request->proDescription;
        $profile->save();

        return Redirect::route('notes.myIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
