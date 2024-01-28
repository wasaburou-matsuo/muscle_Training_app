<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingResult;
use App\Models\TrainingArea;
use App\Models\TrainingEquipment;
use App\Models\TrainingEvent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\TrainingResultsController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TrainingResultCreateRequest;
use App\Http\Requests\TrainingUpdateRequest;

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
    
    //TrainingResultCreateRequestは通常のRequestファザードを継承しているため、
    // RequestをTrainingResultCreateRequestに変更しても、all関数が使えるので問題ない。
    // public function store(Request $request)
    public function store(TrainingResultCreateRequest $request)
    {
        //
        $post = $request->all();
        $uuid = Str::uuid()->toString();
        // dd($post);
        
        //S3に画像アップロード
        $image = $request->file('image');
        //putfile 引数（指定したS3バケットのどのフォルダ,オブジェクト,公開可能なパスを取得）
        $path = Storage::disk('s3')->putFile('training-result', $image, 'public');
        // dd($path);

        //S3のURLを取得
        $url = Storage::disk('s3')->url($path);
        // dd($url);

        //DBにはURLを保存

        try{

        DB::beginTransaction();
        // TrainingResult::create([
            //createだと自動採番してしまうので、uuidを設定する場合はinsertで行う。
            TrainingResult::insert([
            'id' => $uuid,
            'title' => $post['title'],
            'description' => $post['description'],
            'training_areas_id' => $post['category'],
            'image' => $url,
            'user_id' => Auth::id()                   //ログインユーザーのid
        ]);

        // 以下２行のようなデータで、データがフォームから飛んできてほしい。
        // $posts['equipments'] =$posts['equipments'][0]['name']
        // $posts['equipments'] =$posts['equipments'][0]['wheight']

        $equipments = [];
        foreach($post['equipments'] as $key => $equipment){
        $equipments[$key] = [
            'training_results_id' => $uuid,
            'name' => $equipment['name'],
            'weight' => $equipment['weight']
        ];
        }

        // dd($equipments);
        
        TrainingEquipment::insert($equipments);

        $steps = [];
        foreach($post['steps'] as $key => $step){
        $steps[$key] = [
            'training_results_id' => $uuid,
            'step_number' => $key + 1,
            'description' => $step
        ];
        }

        // dd($steps);
        
        TrainingEvent::insert($steps);

        DB::commit();
    }catch(\Throwable $th){
        DB::rollBack();
        \Log::debug(print_r($th->getMessage(), true));
        throw $th;
    }

    flash()->success('トレーニングを投稿しました!');
    return redirect()->route('training_result.show', ['id' => $uuid]);


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

        //トレーニング投稿者とログインユーザーが同じかどうか
        $is_my_training = false;
        // ログインしているかつログインユーザーidと投稿データのidが一致していたら
        if(Auth::check() && (Auth::id() === $training_results['user_id'])){
            $is_my_training = true;
        }

        //リレーションで器具と説明を取得予定
        // dd($training_results);

        //トレーニング用の閲覧ページを作成。
        // return view('training_results.show',compact('training_results'));
        // is_my_training変数をビューに渡し、trueでの場合は、編集ボタンを表示させる。
        return view('training_results.show',compact('training_results','is_my_training'));
        
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $training_results = TrainingResult::with(['equipments','events','reviews.user','user'])
        ->where('training_results.id',$id)
        ->first()->toArray();    
        // ->toArray();   
        $areas = TrainingArea::all();


        // ログインしていないまたはログインユーザーidと投稿データのidが一致していない場合
        if(!Auth::check() || (Auth::id() !== $training_results['user_id'])){
            abort(403);
        }   
        

        return view('training_results.edit',compact('training_results','areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TrainingUpdateRequest $request, string $id)
    {
        //
        $post = $request->all();
        // dd($post);
        // 画像の更新
        //画像更新用の配列
        $update_array = [
        'title' => $post['title'],
        'description' => $post['description'],
        'training_areas_id' => $post['category_id']
        ];

        // 画像が更新されていれば、S3のデータを書き換え、URLを取得する。
        if( $request->hasFile('image') ) {
            $image = $request->file('image');
            // s3に画像をアップロード
            $path = Storage::disk('s3')->putFile('training-result', $image, 'public');
            // s3のURLを取得
            $url = Storage::disk('s3')->url($path);
            // DBにはURLを保存
            $update_array['image'] = $url;
        }

    try{
        //クエリビルダ
        TrainingResult::where('id', $id)->update($update_array);

        // dd($post);
            //一度古いデータを削除してInsertしなおす
            TrainingEquipment::where('training_results_id', $id)->delete();
            TrainingEvent::where('training_results_id', $id)->delete();

            $equipments = [];
            foreach($post['equipments'] as $key => $equipment){
            $equipments[$key] = [
                'training_results_id' => $id,
                'name' => $equipment['name'],
                'weight' => $equipment['weight']
            ];
            }
    
            // dd($equipments);
            
            TrainingEquipment::insert($equipments);
    
            $steps = [];
            foreach($post['steps'] as $key => $step){
            $steps[$key] = [
                'training_results_id' => $id,
                'step_number' => $key + 1,
                'description' => $step
            ];
            }

            TrainingEvent::insert($steps);
            DB::commit();

        }catch(\Throwable $th){
            DB::rollBack();
            \Log::debug(print_r($th->getMessage(), true));
            throw $th;
        }
        flash()->success('トレーニングを更新しました!');
        return redirect()->route('training_result.show', ['id' => $id]);

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
