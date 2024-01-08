<x-app-layout>
    <div class="grid grid-cols-3 gap-4">
      <div class="col-span-2 bg-white rounded p-4">
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
      <div class="col-span-1 bg-white">FORM</div>
      
    </div>
  </x-app-layout>