<x-app-layout>
    {{ Breadcrumbs::render('show', $training_results) }}
    <div class="w-10/12 p-4 mx-auto bg-white rounded">
      <div class="grid grid-cols-2 rounded border border-black">
        <div class="col-span-1">
          <img class="object-cover rounded-t-lg h-40 w-full mrounded-none rounded-l-lg" src="{{$training_results['image']}}" alt="{{$training_results['title']}}">
        </div>
        <div class="col-span-1">
          <p>{{$training_results['description']}}</p>
          <p>ユーザー名</p>
          <h4 class="text-2xl font-bold mb-2">器具</h4>
        </div>
      </div>
    </div>
  </x-app-layout>