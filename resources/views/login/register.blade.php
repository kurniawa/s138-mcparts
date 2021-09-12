@extends('layouts.main_layout')

@section('header-back')
    @parent
@endsection

@section('content')
<style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>

  
  <!-- Custom styles for this template -->
  <link href="/css/signin.css" rel="stylesheet">
<div class="form-container">
    <main class="form-signin text-center">
    <form action="/register" method="POST">
        @csrf
      <img class="mb-4" src="/img/icons/boy.svg" alt="" width="72" height="57">
      <h1 class="h3 mb-3 fw-normal">Form Registrasi Admin</h1>
      <div class="form-floating">
        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Nama" value="{{ old('nama') }}" required>
        <label for="nama">Nama</label>
        @error('nama')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="form-floating">
        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="username" value="{{ old('username') }}" required>
        <label for="username">Username</label>
        @error('username')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      {{-- <div class="form-floating">
        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Email address</label>
      </div> --}}
      <div class="form-floating">
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
        @error('password')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
    
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Registrasi</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
    </form>
    {{-- <small>Belum terdaftar? <a href="/register" class="a-link">Daftar sekarang!</a></small> --}}
    </main>
</div>  
@endsection