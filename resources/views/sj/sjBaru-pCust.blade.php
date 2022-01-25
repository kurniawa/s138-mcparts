@extends('layouts.main_layout')

@section('content')
    
<div class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">

</div>

<div class="m-0_5em">

    <div>
        <h2>Pilihan Nota Berdasarkan Pelanggan</h2>
    </div>

    <div id="divTitleDesc" class="grid-1-auto justify-items-center mt-0_5em"></div>

    <input id="inputHargaTotalSPK" type="hidden">

    <!-- <div id="divJmlTotal" class="text-right p-1em">
        <div id="divJmlTotal2" class="font-weight-bold font-size-2em color-green"></div>
        <div class="font-weight-bold color-red font-size-1_5em">Total</div>
    </div> -->

</div>
<div id="divItemList2" class="p-1em">
    <form action="/nota/notaBaru-pSPK-pItem-DB" method="POST" name="form_pCust_pNota">
        @csrf
        {{-- <input type='checkbox' name='main_checkbox' id='main_checkbox' onclick="checkAll(this.id, 'dd');"> Pilih Semua --}}
        <table style="width:100%;" id="tableItemList"></table>

        <div id="divMarginBottom" style="height: 20vh;"></div>

        <button id="btnSelesai_new" type="submit" class="btn-warning-full" style="display:none">Konfirmasi</button>
    </form>
</div>

<div id="divMarginBottom" style="height: 20vh;"></div>
<style>

</style>

<script>

    const custs_notas = {!! json_encode($custs_notas, JSON_HEX_TAG) !!};
    console.log('custs_notas');
    console.log(custs_notas);

    // Menentukan head dari table
    var htmlCusts = ``;
    var date_today = getDateToday();
    // console.log('date_today');
    // console.log(date_today);
    
    for (let i0 = 0; i0 < custs_notas.length; i0++) {
        var cust = JSON.parse(custs_notas[i0].pelanggan);
        /*
        htmlCusts: menampung element html untuk List Nota Item
        htmlDD: Dropdown pertama, nanti nya akan disisipkan ke htmlCusts
        htmlDD2: Dropdown kedua, nanti nya akan disisipkan ke htmlCusts
        */

        /*
        Parameter untuk Dropdown kedua yang akan di kirim ke function isChecked
        */
        var htmlDD2 = '';
        htmlDD2 += `
        
        `;

        var htmlDD = '';

        htmlDD += `
            <table>
                <tr><td></td></tr>
                <tr><td>Jml. ingin diinput</td><td>:</td><td><input type='number' name='jml_input[]'></td></tr>
                <tr><td><input type='hidden' name='spk_produk_id[]'></td></tr>
            </table>
        `;

        /*
        Parameter untuk Dropdown pertama yang akan di kirim ke function isChecked
        */
        
        var params_dd = {
            id_dd: `#DD-${i0}`,
            class_checkbox: ".dd",
            id_checkbox: `#ddCheckbox-${i0}`,
            id_button: `#btnSelesai_new`,
            // to_uncheck: params_dd2,
        }

        params_dd = JSON.stringify(params_dd);

        htmlCusts += `
            <tr class='bb-1px-solid-grey'><td><input type='radio' name='pCust' value='${cust.id}'>${cust.nama}</td></tr>
            <!-- <tr class='bb-1px-solid-grey'><td><input type='radio' name='pCust' value='test'>test</td></tr> -->
            <tr class='bb-1px-solid-grey'><td><input type='radio' name='pCust' value='test'>test</td></tr>
            <tr id='DD-${i0}' style='display:none'><td colspan=3>${htmlDD}</td></tr>
            <tr id='DD2-${i0}' style='display:none'><td colspan=3>${htmlDD2}</td></tr>
        `;
        
            // <tr id='DD2-${i}' style='display:none'><td colspan=3>${htmlDD2}</td></tr>
    }

    $('#tableItemList').html(htmlCusts);

    var rad_pCust = document.form_pCust_pNota.pCust;
    console.log('rad_pCust');
    console.log(rad_pCust);
    for (var i = 0; i < rad_pCust.length; i++) {
        rad_pCust[i].addEventListener('click', function() {
            console.log(this);
            
        });
        // rad_pCust[i].addEventListener('change', function() {
        //     (prev) ? console.log(prev.value): null;
        //     if (this !== prev) {
        //         prev = this;
        //     }
        //     console.log(this.value)
        // });
    }

    $jmlTotalSPK = 0;
    var element_to_toggle = "";

    // $('#divSPKNumber').html(spk.id);
    $('#divSPKNumber').text('Ditentukan Secara Otomatis Setelah Konfirmasi Pembuatan Nota Baru');
    // $('#divItemList').html(htmlCusts);
    // $('#divTglPembuatan').html(tgl_pembuatan_dmY);

    function checkAll(mainCheckbox_id, classCheckboxChilds) {
        // console.log('mainCheckbox_id, classCheckboxChilds');
        // console.log(mainCheckbox_id, classCheckboxChilds);
        var checkboxChilds = document.querySelectorAll(`.${classCheckboxChilds}`);
        // console.log(checkboxChilds);
        // console.log(checkboxChilds[0]);
        // console.log(checkboxChilds[0].id);

        var i = 0;
        checkboxChilds.forEach(checkboxChild => {
            document.getElementById(checkboxChild.id).checked = true;

            var params_dd = {
                id_dd: `#DD-${i}`,
                class_checkbox: ".dd",
                id_checkbox: `#ddCheckbox-${i}`,
                id_button: `#btnSelesai_new`
            }

            // params_dd = JSON.stringify(params_dd);
            isChecked(params_dd);

            i++;
        });
    }

</script>
@endsection