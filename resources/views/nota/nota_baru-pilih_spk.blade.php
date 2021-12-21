@extends('layouts/main_layout')

@section('content')

<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
</header>

<div class="container m-1em">
    <form action="/nota/nota_baru-pilih_spk-pilih_nota" method="post">
        <input type="hidden" name="_token" value="{{ $csrf }}">
        <span style="font-weight:bold">Pilihan SPK yang Sebagian atau Seluruhnya SELESAI:</span><br>
        <select name="spk_id" id="selectIDSPK" class="p-1em">
            @for ($i = 0; $i < count($available_spk); $i++)
                <option value="{{ $available_spk[$i]['id'] }}">{{ $available_spk[$i]['no_spk'] }}</option>
            @endfor
        </select>
        <br><br>
        <button type="submit" class="btn-warning">Lanjut -> Pilih Nota</button>
    </form>
</div>

<script>
    const available_spk =  {!! json_encode($available_spk, JSON_HEX_TAG) !!};
    console.log("available_spk");
    console.log(available_spk);

    const my_csrf = {!! json_encode($csrf, JSON_HEX_TAG) !!};
    console.log('my_csrf');
    console.log(my_csrf);
</script>

@endsection
