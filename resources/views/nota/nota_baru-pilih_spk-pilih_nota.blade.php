@extends('layouts.main_layout')

@section('content')
    
<div class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">

</div>

<h2>Pilih Nota / Buat Nota Baru</h2>

<div class="container m-1em">
    <form action="/nota/nota_baru-pSPK-pNota-pItem" method="get">
        <span style="font-weight:bold">Pilihan Nota yang berkaitan dengan SPK terpilih:</span><br>
        <select name="spk_id" id="selectIDSPK" class="p-1em">
            <option value="NOTA_BARU">Nota Baru</option>
            @for ($i = 0; $i < count($available_nota); $i++)
            <option value="{{ $available_nota[$i]['id'] }}">{{ $available_nota[$i]['no_spk'] }}</option>
            @endfor
        </select>
        <br><br>
        <button type="submit" class="btn-warning">Lanjut -> Pilih Item</button>
        <input type="hidden" name="_token" value="{{ $csrf }}">
        <input type="hidden" name="spk_id" value="{{ $spk_id }}">
    </form>
</div>

<div id="divItemList"></div>

<div id="divMarginBottom" style="height: 20vh;"></div>
<style>

</style>

<script>

    /*METHODE U. RELOAD PAGE*/
    // const reload_page = {-!! json_encode($reload_page, JSON_HEX_TAG) !!};
    // reloadPage(reload_page);

</script>
@endsection