<x-app-layout>
    <div class="w-10/12 p-4 mx-auto bg-white rounded">
        {{ Breadcrumbs::render('show', $training_results) }}
        {{-- レシピの詳細 --}}
      <div class="grid grid-cols-2 rounded border border-black">
        <div class="col-span-1">
          <img class="object-cover rounded-t-lg h-40 w-full mrounded-none rounded-l-lg" src="{{$training_results['image']}}" alt="{{$training_results['title']}}">
        </div>
        <div class="col-span-1">
          <p>{{$training_results['description']}}</p>
          {{-- userテーブルのnameカラム --}}
          <p>{{$training_results['user']['name']}}</p>
          <h4 class="text-2xl font-bold mb-2">器具</h4>
          {{-- コントローラーから渡ってきた変数をddで確認 --}}
          {{-- withメソッドで取得してきたtraining_equipmentsを表示 --}}
          {{-- {{dd($training_results['training_equipments'])}} --}}
         <ul>
        @foreach($training_results['equipments'] as $i)
            <li>{{$i['name']}}:{{$i['weight']}}</li>
        @endforeach
         </ul>
        </div>
      </div>
      <br>
    <!-- steps -->
    <div class="">
        <h4 class="text-2xl font-bold mb-6">トレーニングステップ</h4>
        <div class="grid grid-cols-4 gap-4">
      @foreach($training_results['events'] as $s)
          <div class="mb-2 background-color p-2">
            <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full mr-4 mb-2">
              {{ $s['step_number'] }}
            </div>
            <p>{{ $s['description'] }}</p>
          </div>
      @endforeach
        </div>
      </div>
    </div>
    @if($is_my_training)
    <a href="{{ route('training_result.edit', ['id' => $training_results['id']]) }}" class="block w-2/12 p-4 my-4 mx-auto bg-white rounded text-center text-green-500 border border-green-500 hover:bg-green-500 hover:text-white">編集する</a>
    @endif
    <!-- reviews -->
    {{-- {{dd($training_results['reviews'])}} --}}
    <div class="w-10/12 p-4 mx-auto bg-white rounded">
      <h4 class="text-2xl font-bold mb-2">レビュー</h4>
    @if( count($training_results['reviews']) === 0)
      <p>レビューはまだありません</p>
    @endif
    @foreach($training_results['reviews'] as $r)
        <div class="background-color rounded mb-4 p-4">
          <div class="flex mb-4">
            {{-- 評価の数（$r['rating']）だけ、ループを行う --}}
        @for($i = 0; $i < $r['rating']; $i++)
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-yellow-400">
              <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
        @endfor
            <p class="ml-2">{{ $r['comment'] }}</p>
          </div>
          <p class="text-gray-600 font-bold">{{ $r['user']['name'] }}</p>
        </div>
    @endforeach    
    </div>
  </x-app-layout>