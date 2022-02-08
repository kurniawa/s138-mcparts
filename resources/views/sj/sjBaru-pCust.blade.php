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
        var notas = JSON.parse(custs_notas[i0].notas);
        /*
        variable dinamakan dengan sebutan jamak, karena bisa jadi pelanggan tersebut dibuatkan
        beberapa nota yang memang belum ada surat jalan nya.
        */
        console.log('notas:');
        console.log(notas);

        var htmlCheckboxNotas = '';
        for (let i_checkboxNota = 0; i_checkboxNota < notas.length; i_checkboxNota++) {
            var notaItem = JSON.parse(notas[i_checkboxNota].data_nota_item)
            console.log('nota_item');
            console.log(notaItem);

            var htmlDataNotaItem = '';
            for (let i_notaItem = 0; i_notaItem < notaItem.length; i_notaItem++) {
                htmlDataNotaItem += `
                <tr>
                <td>${notaItem[i_notaItem].nama_nota}</td>
                <td>${formatHarga(notaItem[i_notaItem].jml_item.toString())}</td>
                <td>${formatHarga(notaItem[i_notaItem].hrg_per_item.toString())}</td>
                <td>${formatHarga(notaItem[i_notaItem].hrg_total_item.toString())}</td>
                </tr>
                `;
            }

            htmlCheckboxNotas += `
            <tr>
            <td class='p-2'><input type='checkbox' name='' value=''></td>
            <td class='p-2'>${notas[i_checkboxNota].no_nota}</td>
            <td class='p-2'>Harga.T: Rp. ${formatHarga(notas[i_checkboxNota].harga_total.toString())},-</td>
            <td class='p-2'><img class='w-0_7em' src='/img/icons/dropdown.svg'></td>
            </tr>
            <tr>
                <td colspan=4>
                    <table style='width:100%'>
                        <tr><th>Nama</th><th>Jml.</th><th>Hrg./pcs</th><th>Hrg.t</th></tr>
                        ${htmlDataNotaItem}
                    </table>
                </td>
            </tr>
            `;
        }

        /*
        Parameter untuk Dropdown kedua yang akan di kirim ke function isChecked
        */
        var htmlDD2 = '';
        htmlDD2 += `
        
        `;

        var htmlDD = '';

        htmlDD += `
            <table style='width:100%'>
                ${htmlCheckboxNotas}
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

            // <tr class='bb-1px-solid-grey'><td><input type='radio' name='pCust' value='test'>test</td></tr>
        htmlCusts += `
            <tr class='bb-1px-solid-grey'><td><input type='radio' name='pCust' value='${cust.id}' onclick='pNota_showDD("DD-${i0}", ${i0});'>${cust.nama}</td></tr>
            <!-- <tr class='bb-1px-solid-grey'><td><input type='radio' name='pCust' value='test'>test</td></tr> -->
            <tr id='DD-${i0}' style='display:none'><td colspan=3>${htmlDD}</td></tr>
            <tr id='DD2-${i0}' style='display:none'><td colspan=3>${htmlDD2}</td></tr>
            <tr class='bb-1px-solid-grey'><td></td></tr>
        `;
        
            // <tr id='DD2-${i}' style='display:none'><td colspan=3>${htmlDD2}</td></tr>
    }

    $('#tableItemList').html(htmlCusts);

    var radio_pCust = document.form_pCust_pNota.pCust;
    console.log('radio_pCust');
    console.log(radio_pCust);

    function pNota_showDD(DD_id, DD_index) {
        console.log(`DD_id: ${DD_id}; DD_index: ${DD_index}`);
        // var nota = JSON.parse(custs_notas[DD_index].notas);
        // console.log(nota);
        $(`#${DD_id}`).show(300);
        // $DD.show();
    }
    // for (var i = 0; i < radio_pCust.length; i++) {
    //     radio_pCust[i].addEventListener('click', function() {
    //         console.log(`i: ${i}`);
    //         console.log(this);
    //         $DD = document.getElementById(`DD-${i}`);
    //         console.log($DD);
    //         // $DD.show();
            
    //     });
    //     // radio_pCust[i].addEventListener('change', function() {
    //     //     (prev) ? console.log(prev.value): null;
    //     //     if (this !== prev) {
    //     //         prev = this;
    //     //     }
    //     //     console.log(this.value)
    //     // });
    // }

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