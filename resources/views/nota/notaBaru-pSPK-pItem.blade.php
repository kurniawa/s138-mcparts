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
            <div id="nomor_nota" class="font-weight-bold"></div>
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
        <input type='checkbox' name='main_checkbox' id='main_checkbox' onclick="checkAll(this.id, 'dd_spk_items');"> Pilih Semua
        <table style="width:100%;" id="tableItemList"></table>

        <div id="divMarginBottom" style="height: 20vh;"></div>

        <button id="btnSelesai_new" type="submit" class="btn-warning-full" style="display:none">Konfirmasi</button>
    </form>
</div>


<div id="divMarginBottom" style="height: 20vh;"></div>
<style>

</style>

<script>
    const show_console = true;
 
    const spks = {!! json_encode($spks, JSON_HEX_TAG) !!};
    const pelanggan = {!! json_encode($pelanggan, JSON_HEX_TAG) !!};
    const arr_av_nota_items = {!! json_encode($arr_av_nota_items, JSON_HEX_TAG) !!};
    const arr_produks = {!! json_encode($arr_produks, JSON_HEX_TAG) !!};
    const tgl_nota = {!! json_encode($tgl_nota, JSON_HEX_TAG) !!};
    const my_csrf = {!! json_encode($csrf, JSON_HEX_TAG) !!};
    
    if (show_console === true) {
        console.log('spks');
        console.log(spks);
        console.log(pelanggan);
        console.log("arr_av_nota_items:");
        console.log(arr_av_nota_items);
        console.log("arr_produks:");
        console.log(arr_produks);
        console.log('tgl_nota');
        console.log(tgl_nota);
    }

    // const tgl_nota_dmY = {-!! json_encode($tgl_nota_dmY, JSON_HEX_TAG) !!};
    // console.log('tgl_nota_dmY');
    // console.log(tgl_nota_dmY);

    // const spk_produks = {-!! json_encode($spk_produks, JSON_HEX_TAG) !!}
    // console.log('spk_produks');
    // console.log(spk_produks);

    // Menentukan head dari table
    
    var date_today = getDateToday();
    // console.log('date_today');
    // console.log(date_today);
    var htmlAll = '';
    for (let i_spks = 0; i_spks < spks.length; i_spks++) {
        htmlAll += `
            <tr><td colspan=3><span style="font-weight:bold">${spks[i_spks].no_spk}</span></td colspan=3></tr>
            <tr><td colspan=3><input type="hidden" name="spk_id[]" value=${spks[i_spks].id}></td></tr>
        `;
        var htmlSPKItem = `<tr>
            <th>Nama</th><th>jml.T</th><th>jml.Av</th><th><th>
        </tr>`;
        for (let i_arrAvNotaItems = 0; i_arrAvNotaItems < arr_av_nota_items[i_spks].length; i_arrAvNotaItems++) {
            /*
            htmlSPKItem: menampung element html untuk List SPK Item
            htmlDD: Dropdown pertama, nanti nya akan disisipkan ke htmlSPKItem
            htmlDD2: Dropdown kedua, nanti nya akan disisipkan ke htmlSPKItem
            */
            var htmlDD = '';
            // var htmlDD2 = '';
            var jml_selesai = arr_av_nota_items[i_spks][i_arrAvNotaItems].jml_selesai;
            var deviasi_jml = 0;
            var sisa_jml = arr_av_nota_items[i_spks][i_arrAvNotaItems].jumlah;
    
            var jml_sdh_nota = 0;
            if (arr_av_nota_items[i_spks][i_arrAvNotaItems].nota_jml_kapan !== null && arr_av_nota_items[i_spks][i_arrAvNotaItems].nota_jml_kapan !== '') {
                var nota_jml_kapan = JSON.parse(arr_av_nota_items[i_spks][i_arrAvNotaItems].nota_jml_kapan);
                console.log('nota_jml_kapan');
                console.log(nota_jml_kapan);
                for (let index = 0; index < nota_jml_kapan.length; index++) {
                    jml_sdh_nota += parseInt(nota_jml_kapan[index].jml_item);
                }
            }
            // if (condition) {
                
            // }
    
            // if (typeof arr_av_nota_items[i_spks][i_arrAvNotaItems].deviasi_jml !== 'undefined') {
            //     deviasi_jml = arr_av_nota_items[i_spks][i_arrAvNotaItems].deviasi_jml;
            // }
            
            // if (typeof arr_av_nota_items[i_spks][i_arrAvNotaItems].jml_selesai !== 'undefined') {
            //     jml_selesai = arr_av_nota_items[i_spks][i_arrAvNotaItems].jml_selesai;
            //     sisa_jml = arr_av_nota_items[i_spks][i_arrAvNotaItems].jumlah - jml_selesai + deviasi_jml;
            // }
    
            // Menentukan warna
            var fColor = 'tomato';
    
            // Menentukan tampilan Jumlah + deviasi_jml
            // ABAIKAN
            // var divJml = `${arr_av_nota_items[i_spks][i_arrAvNotaItems].jumlah}`;
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
               id_dd: `#DD2-${i_spks}`,
               class_checkbox: ".dd_checkbox",
               id_checkbox: `#ddCheckbox2-${i_spks}`,
                id_button: `#none`
            }
    
            params_dd2 = JSON.stringify(params_dd2);
    
            /*
            Menentukan tahapan dari produk
            */
        //    var htmlTahapSelesai = '';
           
        //    if (arr_av_nota_items[i_spks][i_arrAvNotaItems].jmlSelesai_kapan !== null && arr_av_nota_items[i_spks][i_arrAvNotaItems].jmlSelesai_kapan !== '') {
    
        //         var jmlSelesai_kapan_i = arr_av_nota_items[i_spks][i_arrAvNotaItems].jmlSelesai_kapan;
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
                    <tr><td>Jml. sudah Nota</td><td>:</td><td>${jml_sdh_nota}<input type='hidden' name='jml_sdh_nota[${i_spks}][]' value=${jml_sdh_nota}></td></tr>
                    <tr><td>Jml. ingin diinput</td><td>:</td><td><input type='number' name='jml_input[${i_spks}][]' value=${jml_selesai-jml_sdh_nota}></td></tr>
                    <tr><td><input type='hidden' name='spk_produk_id[${i_spks}][]' value='${arr_av_nota_items[i_spks][i_arrAvNotaItems].id}'></td></tr>
                </table>
            `;
    
            // htmlDD2 += `
            //     <table>
            //         <tr><td><select name='tahap-${i_spks}'>${htmlTahapSelesai}</select></td></tr>
            //         <tr><td>Tgl. Selesai</td><td>:</td><td><input type='date' id='date_today-${i_spks}' name='tgl_selesai_dd-${i_spks}' value='${date_today}'></td></tr>
            //     </table>
            // `;
    
            /*
            Parameter untuk Dropdown pertama yang akan di kirim ke function isChecked
            */
            
            var params_dd = {
                id_dd: `#DD-${i_spks}${i_arrAvNotaItems}`,
                class_checkbox: ".dd_spk_items",
                id_checkbox: `#ddCheckbox-${i_spks}${i_arrAvNotaItems}`,
                id_button: `#btnSelesai_new`,
                // to_uncheck: params_dd2,
            }
    
            params_dd = JSON.stringify(params_dd);
    
            htmlSPKItem += `
                <tr class='bb-1px-solid-grey'>
                    <td style='color:${fColor};font-weight:bold;font-size:1em;padding-bottom:1em;padding-top:1em;' class=''>${arr_produks[i_spks][i_arrAvNotaItems].nama}</td>
                    <td style='color:slateblue;font-weight:bold;'>${arr_av_nota_items[i_spks][i_arrAvNotaItems].jumlah + arr_av_nota_items[i_spks][i_arrAvNotaItems].deviasi_jml}<input type='hidden' name='jml_t[${i_spks}][]' value='${arr_av_nota_items[i_spks][i_arrAvNotaItems].jumlah + arr_av_nota_items[i_spks][i_arrAvNotaItems].deviasi_jml}'></td>
                    <td style='color:green;font-weight:bold;'>${arr_av_nota_items[i_spks][i_arrAvNotaItems].jml_selesai - arr_av_nota_items[i_spks][i_arrAvNotaItems].jml_sdh_nota}<input type='hidden' name='jml_av[${i_spks}][]' value='${arr_av_nota_items[i_spks][i_arrAvNotaItems].jml_selesai - arr_av_nota_items[i_spks][i_arrAvNotaItems].jml_sdh_nota}'></td>
                    <td><input type='checkbox' id='ddCheckbox-${i_spks}${i_arrAvNotaItems}' class='dd_spk_items' onclick='isChecked(${params_dd});'></td>
                </tr>
                <tr id='DD-${i_spks}${i_arrAvNotaItems}' style='display:none'><td colspan=3>${htmlDD}</td></tr>
            `;
            
                // <tr id='DD2-${i_spks}' style='display:none'><td colspan=3>${htmlDD2}</td></tr>
            
        }
        htmlAll += htmlSPKItem;
    }

    $('#tableItemList').html(htmlAll);

    $jmlTotalSPK = 0;
    var element_to_toggle = "";

    // $('#nomor_nota').html(spk.id);
    $('#nomor_nota').text('Ditentukan Secara Otomatis Setelah Konfirmasi Pembuatan Nota Baru');
    // $('#divItemList').html(htmlSPKItem);
    // $('#divTglPembuatan').html(tgl_pembuatan_dmY);
    $('#divSPKCustomer').html(`${pelanggan.nama} - ${pelanggan.daerah}`);

    function checkAll(mainCheckbox_id, classCheckboxChilds) {
        var checkboxChilds = document.querySelectorAll(`.${classCheckboxChilds}`);
        if (show_console === true) {
            console.log('mainCheckbox_id, classCheckboxChilds');
            console.log(mainCheckbox_id, classCheckboxChilds);
            console.log('checkboxChilds')
            console.log(checkboxChilds);
        }

        var i_spks = 0;
        checkboxChilds.forEach(checkboxChild => {
            document.getElementById(checkboxChild.id).checked = true;
            if (show_console === true) {
                console.log("checkboxChild.id");
                console.log(checkboxChild.id);
            }
            var id_number = checkboxChild.id.split("-");

            var params_dd = {
                id_dd: `#DD-${id_number[1]}`,
                class_checkbox: ".dd_spk_items",
                id_checkbox: `#ddCheckbox-${id_number[1]}`,
                id_button: `#btnSelesai_new`
            }

            // params_dd = JSON.stringify(params_dd);
            isChecked(params_dd);

            i_spks++;
        });
    }

</script>
@endsection