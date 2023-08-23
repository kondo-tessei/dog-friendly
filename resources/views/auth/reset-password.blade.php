@extends('layouts.html')

@section('content')

@extends('layouts.footer')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center">パスワード変</h1>
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email" class="col-form-label text-center">メールアドレス</label>
                        <input id="email" type="email" class="form-control" type="email" name="email" :value="old('email', $email)" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!-- <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $email)" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div> -->

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="col-form-label text-center">新しいパスワード</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!-- <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div> -->

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="col-form-label text-center" :value="__('Confirm Password')" >確認用パスワード</label>

                        <input id="password_confirmation" class="form-control @error('password') is-invalid @enderror"
                                            type="password"
                                            name="password_confirmation" required autocomplete="new-password" />

                        <input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="text-center mt-4">
                        <x-primary-button>
                            {{ __('Reset Password') }}
                        </x-primary-button>
                    </div>
                </form>
        </div>
    </div>
</div>

<style>
    /* カスタムCSS */
    .btn-custom-width {
        width: 120px; 
    }
</style>


@endsection