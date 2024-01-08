<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingResult;

class TrainingResultController extends Controller
{

    public function home(){
        //モデル（TrainingResult.php）からトレーニング実績を新着順に３つ取得
        $training_results = TrainingResult::select ('training_results.id', 'training_results.title', 'training_results.description' ,
        'training_results.created_at' , 'training_results.image' ,'users.name')
        ->join('users' ,'users.id' ,'=' ,'training_results.user_id')
        ->orderby('created_at', 'desc')
        ->limit(3)
        ->get();

        //モデル（TrainingResult.php）から人気(閲覧数の多い）のトレーニング実績を新着順に３つ取得
        $popular = TrainingResult::select ('training_results.id', 'title', 'training_results.description' ,
        'training_results.created_at' , 'training_results.image' ,'training_results.views','users.name')
        ->join('users' ,'users.id' ,'=' ,'training_results.user_id')
        ->orderby('views', 'desc')
        ->limit(2)
        ->get();
        
        //dump die
        // dd($popular);

        // Modelから取得してきたデータ(変数)をビューへ渡す。
        return view('home', compact('training_results','popular'));

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //モデル（TrainingResult.php）からトレーニング実績の一覧を取得
        $training_results = TrainingResult::select ('training_results.id', 'training_results.title', 'training_results.description' ,
        'training_results.created_at' , 'training_results.image' ,'users.name')
        ->join('users' ,'users.id' ,'=' ,'training_results.user_id')
        ->orderby('created_at', 'desc')
        ->get();

        // dd($training_results);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
