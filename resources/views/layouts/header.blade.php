<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="dog-friendly">
      <img src="{{ asset('img/logo.png') }}" alt="Dog Friendly" class="img-responsive" style="width: 100px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="margin-right: 30px;">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto ">
      <li class="nav-item">
          <a class="nav-link" href="{{ route('top') }}">トップページ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/">新規登録</a>
        </li>
        @if(Auth::check())
        <li class="nav-item">
          <a class="nav-link" href="/logout">ログアウト</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link" href="/roguin">ログイン</a>
        </li>
        @endif
        <li class="nav-item">
          <a class="nav-link" href="/institution-register">施設登録</a>
        </li>
       
      </ul>
      @if(Auth::check())
      <span class="navbar-text mx-3">
        Name: <strong>{{ Auth::user()->name }}</strong>
      </span>
      @endif
    </div>
  </div>
</nav>