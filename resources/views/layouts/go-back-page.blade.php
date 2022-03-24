@extends('layouts.main_layout')

@section('content')

<div class="mt-2em text-center">
    <button id='backToSPK' class="btn-1 d-inline-block bg-color-orange-1" onclick="windowHistoryGo({{ $go_back_number }});">Kembali</button>
</div>

<script>
    // Metode reload page dengan javascript untuk nantinya pada saat pindah halaman
    sessionStorage.setItem("reload_page", true);
    reloadable_page = false; // reloadable_page di set sebagai false, supaya halaman ini jangan di reload. Fokus reload adalah untuk halaman setelah kembali.
 </script>
@endsection
