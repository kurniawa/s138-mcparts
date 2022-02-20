@extends('layouts.main_layout')

@section('content')
    
<div class="mt-2em text-center">
    <button id='backToSPK' class="btn-1 d-inline-block bg-color-orange-1" onclick="windowHistoryGo({{ $go_back_number }});">Kembali</button>
</div>

<script>
    // Metode reload page dengan javascript untuk nantinya pada saat pindah halaman
    var load_num = localStorage.getItem("load_num");
    if (load_num === null) {
        localStorage.setItem("load_num", 0);
    } else {
        load_num = parseInt(load_num);
        localStorage.setItem("load_num", load_num++);
    }
 </script>
@endsection