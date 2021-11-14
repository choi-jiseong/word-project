<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Stichoza\GoogleTranslate\GoogleTranslate;

class WordNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::latest()->where('pubpriv', true)->paginate(8);
        // $user = User::find(auth()->user()->id);
        return Inertia::render('Notes/NoteList', ['notes' => $notes]);
    }

    public function myIndex()
    {
        $notes = Note::latest()->where('user_id', auth()->user()->id)->paginate(8);
        return Inertia::render('Notes/MyProfile', ['notes' => $notes, 'followers' => auth()->user()->profile->followers]);
    }

    public function searchLanguage($str) {
        $client_id = env("NA_CLIENT_ID"); // 네이버 개발자센터에서 발급받은 CLIENT ID
        $client_secret = env("NA_CLIENT_SECRET");
        $encQuery = urlencode($str);
        $postvars = "query=".$encQuery;
        $url = "https://openapi.naver.com/v1/papago/detectLangs";
        $is_post = true;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $postvars);
        $headers = array();
        $headers[] = "X-Naver-Client-Id: ".$client_id;
        $headers[] = "X-Naver-Client-Secret: ".$client_secret;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // echo "status_code:".$status_code."<br>";
        curl_close ($ch);
        if($status_code == 200) {
        //   echo $response;
        } else {
        //   echo "Error 내용:".$response;
        }
        $data = json_decode($response);

        return $data->langCode;
    }

    public function searchWord(Request $request) {
        $lang = $this->searchLanguage($request->word);
        // $tr = new GoogleTranslate('ja');
        // return $tr->translate($request->word);
        $client_id = env("NA_CLIENT_ID"); // 네이버 개발자센터에서 발급받은 CLIENT ID
        $client_secret = env("NA_CLIENT_SECRET");// 네이버 개발자센터에서 발급받은 CLIENT SECRET
        $encText = urlencode($request->word);
        if($lang == 'ja') {
            $target = 'ko';
        }else {
            $target = 'ja';
        }
        $postvars = "source=".$lang."&target=".$target."&text=".$encText;
        $url = "https://openapi.naver.com/v1/papago/n2mt";
        $is_post = true;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $postvars);
        $headers = array();
        $headers[] = "X-Naver-Client-Id: ".$client_id;
        $headers[] = "X-Naver-Client-Secret: ".$client_secret;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // echo "status_code:".$status_code."<br>";
        curl_close ($ch);
        if($status_code == 200) {
        //   echo $response;
            $data = json_decode($response);
            return $data->message->result->translatedText;
        } else {
        //   echo "Error 내용:".$response;
            return "올바르게 입력해 주세요";
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
        // dd($request);
        // $request->validate(['title' => 'required']);
        $note = Note::create(['title' => $request->title, 'user_id' => auth()->user()->id, 'pubpriv' => $request->pubpriv]);
        // dd($note);
        // return Redirect::route('notes.index');

        return $note->id;

    }

    public function wordStore(Request $request)
    {
        // dd($request);
        // $request->validate(['language' => 'required', 'mean' => 'required']);
        Word::create(['language' => $request->language, 'mean' => $request->mean, 'note_id' => $request->note_id]);

        if($request->currentBol) {
            return Redirect::route('notes.show', ['noteId' => $request->note_id]);
        }else{
            return Redirect::route('notes.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $note = Note::find($id);
        $userName = User::find($note->user_id)->name;
        if($note->pubpriv == false) {
            if (auth()->user()->id != $note->user_id) {
                abort(403);
            }
        }

        return Inertia::render('Notes/ShowNote', ['note' => $note->load('user')]);
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
        $note = Note::find($id);
        $note->title = $request->title;
        $note->pubpriv = $request->pubpriv;
        $note->save();

        return $note->id;
    }

    public function wordUpdate(Request $request, $id)
    {
            $word = Word::find($id);
            $word->language = $request->language;
            $word->mean = $request->mean;
            $word->save();

        return Redirect::route('notes.show', ['noteId' =>$word->note_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::find($id);
        $note -> delete();

        return Redirect::route('notes.index');
    }

    public function wordDestroy($id) {
        $word = Word::find($id);
        $noteId = $word->note_id;
        $word->delete();

        return Redirect::route('notes.show', ['noteId' =>$noteId]) ;
    }
}
