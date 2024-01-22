<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingResult;
use App\Models\TrainingArea;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\TrainingResultsController;

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
        //  dd($popular);

        // Modelから取得してきたデータ(変数)をビューへ渡す。
        return view('home', compact('training_results','popular'));

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //リクエストで送られてきたデータをすべて取得
        $filters = $request->all();
        // dd($filters);

        // //モデル（TrainingResult.php）からトレーニング実績の一覧を取得
        // $training_results = TrainingResult::select ('training_results.id', 'training_results.title', 'training_results.description' ,
        // 'training_results.created_at' , 'training_results.image' ,'users.name')
        // ->join('users' ,'users.id' ,'=' ,'training_results.user_id')
        // ->orderby('created_at', 'desc')
        // ->get();

        //query()メソッドを使用して、上記クエリを分割する。
        // クエリビルダを使用して取得
        $query = TrainingResult::query()->select ('training_results.id', 'training_results.title', 'training_results.description' ,
        'training_results.created_at' , 'training_results.image' ,'users.name'
        ,\DB::raw('AVG(training_reviews.rating) as rating'))
        ->join('users' ,'users.id' ,'=' ,'training_results.user_id')
        ->leftJoin('training_reviews','training_results.id' , '=' , 'training_results.id')
        ->groupBy('training_results.id')
        ->orderby('created_at', 'desc');

        //リクエストで送られてきたデータが空(絞り込みが無い）の場合は、スルー
        if(!empty($filters)){
            //カテゴリで絞り込み
            if(!empty($filters['categories'])){
                //カテゴリで絞り込みがあった場合は、クエリに追加することが可能。whereIn（含まれていたら）
                //カテゴリIDが含まれているレシピを取得。
                $query->whereIn('training_results.training_areas_id',$filters['categories']);
            }
            // dd($query);

            //評価で絞り込み
            if(!empty($filters['rating'])){
                //havingRowで、生のSQLをしてすることが出来る（havingとは異なる）
                //テーブル結合し、グループ化した後、評価の平均値を出力する。
                $query->havingRaw('AVG(training_reviews.rating) >= ?',[$filters['rating']])
                ->orderBy('rating', 'desc');
            }
            // dd($query);
            
            //キーワード検索（あいまい検索）で絞り込み
            if(!empty($filters['title'])){
                //キーワードで絞り込みがあった場合は、クエリに追加することが可能。whereIn（含まれていたら）
                //トレーニング実績テーブルのtitelカラムにキーワードが含まれるデータ（トレーニング実績）を取得。
                $query->where('training_results.title','like', '%'.$filters['title'].'%');
            }
            // dd($query);

        }

        // $training_results= $query->get();
        //ページネーション対応
        // $training_results= $query->pagenate(5);
        $training_results = $query->paginate(5);
        // dd($training_results);

        //検索用のすべてのカテゴリを取得
        $categories = TrainingArea::all();

        return view('training_results.index', compact('training_results','categories','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = TrainingArea::all();
        // dd($areas);

        return view('training_results.create',compact('areas'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $post = $request->all();
        // dd($posts);
        //S3に画像アップロード


        //S3のURLをアップロード

        //DBにはURLを保存
        

        // TrainingResult::create([
            //createだと自動採番してしまうので、uuidを設定する場合はinsertで行う。
            TrainingResult::insert([
            'id' => Str::uuid(),
            'title' => $post['title'],
            'description' => $post['description'],
            'training_areas_id' => $post['category'],
            'user_id' => Auth::id()                   //ログインユーザーのid
        ]);



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // dd($id);

        //findメソッドで、idに一致するデータを１つだけ取得
        // $training_results = TrainingResult::find($id);
        // $training_equipments = TrainingEquipment::where('training_results_id',$training_results['id'])->get();
        // $training_Events = TrainingEvent::where('training_results_id',$training_results['id'])->get();
        // $training_Reviews = TrainingReview::where('training_results_id',$training_results['id'])->get();

        //以上のソースコードをwithメソッドで、トレーニング実績のidに一致する関連データを複数のテーブルから一気に取得出来る。
        //withメソッドの引数は、モデルに記述した関数名を使用する。
        // $training_results = TrainingResult::with('equipments','events','reviews','user')

        // レビュー情報からユーザーデータを取得するため、reviews.userとする。
        //流れ（実績モデルからレビューモデルを呼び、レビューモデルからユーザーを取得）
        //ORMで記述
        $training_results = TrainingResult::with(['equipments','events','reviews.user','user'])
        ->where('training_results.id',$id)
        // ->get();
        // $training_results = $training_results[0];
        // 取得した配列の最初の要素だけ取得
        ->first();

        // dd($training_results);
        
        //ページ閲覧数を＋１する
        $training_results_recode = TrainingResult::find($id);
        // dd($training_results_recode);
        $training_results_recode->increment('views');
        // $training_results_recode = TrainingResult::find($id);
        // $training_results_recode->increment('views');

        //リレーションで器具と説明を取得予定


        // dd($training_results);

        //トレーニング用の閲覧ページを作成。
        return view('training_results.show',compact('training_results'));
        
        
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
