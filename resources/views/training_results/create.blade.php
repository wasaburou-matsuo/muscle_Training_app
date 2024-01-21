    <x-app-layout>
        <form action="{{route('training_result.store')}}" method="POST" class="w-10/12 p-4 mx-auto bg-white rounded">
          @csrf
            {{ Breadcrumbs::render('create') }}
            <div class="grid grid-cols-2 rounded border border-gray-500 mt-4">
              <div class="col-span-1">
                <img class="object-cover w-full aspect-video" src="/images/recipe-dummy.png" alt="recipe-image">
              </div>
              <div class="col-span-1 p-4">
                <input type="text" name="title" placeholder="トレーニング名" class="border border-gray-300 p-2 mb-4 w-full rounded">
                <textarea name="description" placeholder="トレーニングの説明" class="border border-gray-300 p-2 mb-4 w-full roundedl"></textarea>
                <div class="flex justify-end">
                  <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">レシピを投稿する</button>              </div>
                </div>  
        </form>
    </x-app-layout> 