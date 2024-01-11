<x-app-layout>
    <div class="grid grid-cols-3 gap-4">
      <div class="col-span-2 bg-white rounded p-4">
        {{ Breadcrumbs::render('index') }}
        <div class = "mb-4"></div>
        @foreach($training_results as $training_result)
            <a href="" class="flex flex-col items-center bg-white mb-6 border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100">
                <img class="object-cover rounded-t-lg h-40 w-40 mrounded-none rounded-l-lg" src="{{$training_result->image}}" alt="{{$training_result->title}}">
                <div class="flex flex-col justify-between p-4 leading-normal">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-800">{{$training_result->title}}</h5>
                <p class="mb-3 font-normal">{{ $training_result->description }}</p>
                <div class="flex">
                    <p class="font-bold mr-2">{{$training_result->name}}</p>
                    {{-- format関数はTimestanp型のみ使用可能 --}}
                    <p class="text-gray-500">{{$training_result->created_at->format('Y年m月d日')}}</p>
                </div>
                </div>
            </a>
        @endforeach
      </div>

      <div class="col-span-1 bg-white p-4 h-max sticky top-4">
        {{-- web.phpの/training_resultルートをみにいく。ルート名がtraining_result.indexである。 --}}
        <form action="{{route('training_result.index')}}" method="GET">
        <div class="flex">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-700 mr-2">
            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" />
          </svg>
          <h3 class="text-xl text-gray-800 font-bold mb-4">トレーニング検索</h3>
        </div>
        <div class="mb-4 p-6 border border-gray-300">
          <label class="text-lg text-gray-800">評価</label>
          <div class="ml-4 mb-2">
            <input type="radio" name="rating" value="0" id="rating0" 
            {{-- {{ $filters['rating'] ? '' : 'checked'}}/> --}}
            {{-- もし、ratingのフィルターがあったら、空文字を返す。そうでなければ、'checked'を返す。 --}}
            {{ ($filters['rating'] ?? null) == null ? 'checked' : ''}}/>
            {{-- もし、ratingのフィルター(値)が無かったら、Checkedを入れなさい。そうでなければ、何も入れない。 --}}
            <label for="rating0">指定しない</label>
          </div>
          <div class="ml-4 mb-2">
            <input type="radio" name="rating" value="3" id="rating3"
            {{-- {{ $filters['rating'] == "3" ? 'checked' : '' }}/> --}}
            {{-- もし、ratingのフィルターが3だったら、checkedを返す。そうでなければ、空文字を返す。 --}}
            {{ ($filters['rating'] ?? null) == "3" ? 'checked' : ''}}/>
            {{-- もし、ratingのフィルター(値)が3だったら、Checkedを入れなさい。そうでなければ、何も入れない。 --}}
            <label for="rating3">3以上</label>
          </div>
          <div class="ml-4 mb-2">
            <input type="radio" name="rating" value="4" id="rating4"
            {{-- {{ ($filters['rating'] ?? null) == "4" ? 'checked' : ''}}/> --}}
            {{-- もし、ratingのフィルターが4だったら、checkedを返す。そうでなければ、空文字を返す。 --}}
            {{ ($filters['rating'] ?? 4) == null ? 'checked' : ''}}/>
            {{-- もし、ratingのフィルター(値)が3だったら、Checkedを入れなさい。そうでなければ、何も入れない。 --}}
            <label for="rating4">4以上</label>
          </div>
        </div> 
        <div class="mb-4 p-6 border border-gray-300">
          <label class="text-lg text-gray-800">カテゴリー</label>
          @foreach($categories as $category)
          <div class="ml-4 mb-2">
            {{-- カテゴリは配列categories[]にして渡すことがポイント --}}
            <input type="checkbox" name="categories[]" value="{{$category['id']}}" 
            id="category{{$category['id']}}" 
            {{-- in_arrayは、第２引数の配列の中に第１引数に指定した値（foreachで回している表示されているすべてのカテゴリID）が含まれているかを判定 --}}
            {{-- もし、カテゴリにチェックが入っていない（$filters['categories']に値が無かったら）、空配列とする。→何もCheckがされていない場合、エラーとなるので、null合体演算子を使用--}}
            {{-- in_array関数の第１引数に指定した値と比較して、存在していたら、checkedを有効にし、falseの場合は、空白('')とする。 --}}
            {{ (in_array($category['id'], $filters['categories'] ?? [])) ? 'checked' : '' }}/>
            <label for="category{{$category['id']}}">{{$category['name']}}</label>
          </div>
      @endforeach
            </div> 
        <input type="text" name="title" value="{{ $filters['title'] ?? '' }}" placeholder="トレーニング名を入力" 
        class="border border-gray-300 p-2 mb-4 w-full">
        <div class="text-center">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">検索</button>
        </div>
        </form>
      </div>
      
    </div>
  </x-app-layout>