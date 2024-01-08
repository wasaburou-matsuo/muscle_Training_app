<section class="flex bg-white shadow h-10 py-2 border-b-2">
    <div class="container mx-auto flex justify-between">
      <p class="">今日も筋トレが楽しみだ！</p>
      <div class="flex">

    {{-- ディレクティブを使用して、ログイン状態で処理を分岐する --}}
    @auth
        {{-- {route('profile.edit')}は、laravelのルート関数で、URLに変換してくれる --}}
        <a href="{{route('profile.edit')}}" class="ml-auto">マイページ</a>
    @endauth
    @guest
        <a href="{{route('register')}}" class="mr-2">ユーザー登録（無料）</a>
        <a href="{{route('login')}}" class="">ログイン</a>
    @endauth
      </div>
    </div>
  </section>