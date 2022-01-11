@extends('layouts.main_layout')

@section('content')
    
<div class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">

</div>

<div class="m-0_5em">

    <div class="b-1px-solid-grey">
        <div class="text-center">
            <h2>Nota Baru</h2>
        </div>
        <div class="grid-3-25_10_auto m-0_5em grid-row-gap-1em">
            <div>No.</div>
            <div>:</div>
            <div id="divSPKNumber" class="font-weight-bold"></div>
            <div>Tanggal</div>
            <div>:</div>
            <div id="divTglPembuatan" class="font-weight-bold"><input type="datetime-local" class="input-select-option-1 pb-1em" name="tgl_pembuatan" id="inputTglPembuatan" value="{{ $tgl_nota }}"></div>
            <div>Untuk</div>
            <div>:</div>
            <div id="divSPKCustomer" class="font-weight-bold"></div>
            <input id="inputIDCustomer" type="hidden" name="inputIDCustomer">
        </div>
        <div class="grid-1-auto justify-items-right m-0_5em">
            <div>
                <img class="w-1em" src="/img/icons/edit-grey.svg" alt="">
            </div>
        </div>
    </div>

    <div id="divTitleDesc" class="grid-1-auto justify-items-center mt-0_5em"></div>

    <input id="inputHargaTotalSPK" type="hidden">

    <!-- <div id="divJmlTotal" class="text-right p-1em">
        <div id="divJmlTotal2" class="font-weight-bold font-size-2em color-green"></div>
        <div class="font-weight-bold color-red font-size-1_5em">Total</div>
    </div> -->

</div>
<div id="divItemList2" class="p-1em">
    <form action="/nota/notaBaru-pSPK-pItem-DB" method="POST">
        @csrf
        <input type='checkbox' name='main_checkbox' id='main_checkbox' onclick="checkAll(this.id, 'dd');"> Pilih Semua
        <table style="width:100%;" id="tableItemList"></table>

        <div id="divMarginBottom" style="height: 20vh;"></div>

        <button id="btnSelesai_new" type="submit" class="btn-warning-full" style="display:none">Konfirmasi</button>
        <input type="hidden" name="spk_id" value="{{ $spk['id'] }}">
    </form>
</div>

<div id="divMarginBottom" style="height: 20vh;"></div>
<style>

</style>

<script>

const spk = {!! json_encode($spk, JSON_HEX_TAG) !!};
    console.log('spk');
    console.log(spk);

    const pelanggan = {!! json_encode($pelanggan, JSON_HEX_TAG) !!};
    console.log(pelanggan);

    const nota_item_av = {!! json_encode($nota_item_av, JSON_HEX_TAG) !!};
    console.log("nota_item_av:");
    console.log(nota_item_av);

    const produks = {!! json_encode($produks, JSON_HEX_TAG) !!};
    console.log("produks:");
    console.log(produks);

    const tgl_nota = {!! json_encode($tgl_nota, JSON_HEX_TAG) !!};
    console.log('tgl_nota');
    console.log(tgl_nota);

    const my_csrf = {!! json_encode($csrf, JSON_HEX_TAG) !!};

    // const tgl_nota_dmY = {-!! json_encode($tgl_nota_dmY, JSON_HEX_TAG) !!};
    // console.log('tgl_nota_dmY');
    // console.log(tgl_nota_dmY);

    // const spk_produks = {-!! json_encode($spk_produks, JSON_HEX_TAG) !!}
    // console.log('spk_produks');
    // console.log(spk_produks);

    // Menentukan head dari table
    var htmlSPKItem = `<tr>
        <th>Nama</th><th>jml.T</th><th>jml.Av</th><th><th>
    </tr>`;
    var date_today = getDateToday();
    // console.log('date_today');
    // console.log(date_today);
    
    for (let i = 0; i < nota_item_av.length; i++) {
        /*
        htmlSPKItem: menampung element html untuk List SPK Item
        htmlDD: Dropdown pertama, nanti nya akan disisipkan ke htmlSPKItem
        htmlDD2: Dropdown kedua, nanti nya akan disisipkan ke htmlSPKItem
        */
        var htmlDD = '';
        // var htmlDD2 = '';
        var jml_selesai = nota_item_av[i].jml_selesai;
        var deviasi_jml = 0;
        var sisa_jml = nota_item_av[i].jumlah;

        var jml_sdh_nota = 0;
        if (nota_item_av[i].nota_jml_kapan !== null && nota_item_av[i].nota_jml_kapan !== '') {
            var nota_jml_kapan = JSON.parse(nota_item_av[i].nota_jml_kapan);
            console.log('nota_jml_kapan');
            console.log(nota_jml_kapan);
            for (let index = 0; index < nota_jml_kapan.length; index++) {
                jml_sdh_nota += nota_jml_kapan[index].jml_item;
            }
        }
        // if (condition) {
            
        // }

        // if (typeof nota_item_av[i].deviasi_jml !== 'undefined') {
        //     deviasi_jml = nota_item_av[i].deviasi_jml;
        // }
        
        // if (typeof nota_item_av[i].jml_selesai !== 'undefined') {
        //     jml_selesai = nota_item_av[i].jml_selesai;
        //     sisa_jml = nota_item_av[i].jumlah - jml_selesai + deviasi_jml;
        // }

        // Menentukan warna
        var fColor = 'tomato';

        // Menentukan tampilan Jumlah + deviasi_jml
        // ABAIKAN
        // var divJml = `${nota_item_av[i].jumlah}`;
        // if (deviasi_jml !== 0) {
        //     if (deviasi_jml < 0) {
        //         divJml += `<span>${deviasi_jml}</span>`;
        //     } else {
        //         divJml += `<span>+${deviasi_jml}</span>`;
        //     }
        // }
        // END OF ABAIKAN

        if (sisa_jml === 0) {
            fColor = 'slateblue';
        }
        /*
        Parameter untuk Dropdown kedua yang akan di kirim ke function isChecked
        */
       var params_dd2 = {
           id_dd: `#DD2-${i}`,
           class_checkbox: ".dd_checkbox",
           id_checkbox: `#ddCheckbox2-${i}`,
            id_button: `#none`
        }

        params_dd2 = JSON.stringify(params_dd2);

        /*
        Menentukan tahapan dari produk
        */
    //    var htmlTahapSelesai = '';
       
    //    if (nota_item_av[i].jmlSelesai_kapan !== null && nota_item_av[i].jmlSelesai_kapan !== '') {

    //         var jmlSelesai_kapan_i = nota_item_av[i].jmlSelesai_kapan;
    //         jmlSelesai_kapan_i = JSON.parse(jmlSelesai_kapan_i);

    //         console.log('jmlSelesai_kapan_i');
    //         console.log(jmlSelesai_kapan_i);

    //         if (jmlSelesai_kapan_i.length !== 0) {
    //             let i2 = 0
    //             for ( i2 ; i2 < jmlSelesai_kapan_i.length; i2++) {
    //                 htmlTahapSelesai += `<option value=${jmlSelesai_kapan_i[i2].tahap}>Tahap - ${jmlSelesai_kapan_i[i2].tahap}</option>`;
    //             }
    //             i2++;
    //             htmlTahapSelesai += `<option value=${i2}>Tahap - ${i2}</option>`;
    //         }
    //     } else {
    //         htmlTahapSelesai += '<option value="1">Tahap - 1</option>';
    //     }

        htmlDD += `
            <table>
                <tr><td>Jml. sudah Nota</td><td>:</td><td>${jml_sdh_nota}</td></tr>
                <tr><td>Jml. ingin diinput</td><td>:</td><td><input type='number' name='jml_input[]' value=${jml_selesai} disabled></td></tr>
                <tr><td><input type='hidden' name='spk_produk_id[]' value='${nota_item_av[i].id}' disabled></td></tr>
            </table>
        `;

        // htmlDD2 += `
        //     <table>
        //         <tr><td><select name='tahap-${i}'>${htmlTahapSelesai}</select></td></tr>
        //         <tr><td>Tgl. Selesai</td><td>:</td><td><input type='date' id='date_today-${i}' name='tgl_selesai_dd-${i}' value='${date_today}'></td></tr>
        //     </table>
        // `;

        /*
        Parameter untuk Dropdown pertama yang akan di kirim ke function isChecked
        */
        
        var params_dd = {
            id_dd: `#DD-${i}`,
            class_checkbox: ".dd",
            id_checkbox: `#ddCheckbox-${i}`,
            id_button: `#btnSelesai_new`,
            // to_uncheck: params_dd2,
        }

        params_dd = JSON.stringify(params_dd);

        htmlSPKItem += `
            <tr class='bb-1px-solid-grey'>
                <td style='color:${fColor};font-weight:bold;font-size:1em;padding-bottom:1em;padding-top:1em;' class=''>${produks[i].nama}</td>
                <td style='color:slateblue;font-weight:bold;'>${nota_item_av[i].jumlah + nota_item_av[i].deviasi_jml}</td>
                <td style='color:green;font-weight:bold;'>${nota_item_av[i].jml_selesai}</td>
                <td><input type='checkbox' id='ddCheckbox-${i}' class='dd' onclick='isChecked(${params_dd});'></td>
            </tr>
            <tr id='DD-${i}' style='display:none'><td colspan=3>${htmlDD}</td></tr>
        `;
        
            // <tr id='DD2-${i}' style='display:none'><td colspan=3>${htmlDD2}</td></tr>
    }

    $('#tableItemList').html(htmlSPKItem);

    $jmlTotalSPK = 0;
    var element_to_toggle = "";

    // $('#divSPKNumber').html(spk.id);
    $('#divSPKNumber').text('Ditentukan Secara Otomatis Setelah Konfirmasi Pembuatan Nota Baru');
    $('#divTitleDesc').html(spk.ktrg);
    // $('#divItemList').html(htmlSPKItem);
    // $('#divTglPembuatan').html(tgl_pembuatan_dmY);
    $('#divSPKCustomer').html(`${pelanggan.nama} - ${pelanggan.daerah}`);
    $('#divTitleDesc').html(spk.judul);
    $('#taKeteranganTambahan').html(spk.ktrg);

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