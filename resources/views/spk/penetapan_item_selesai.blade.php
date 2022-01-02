@extends('layouts.main_layout')

@section('content')
    
<div class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">

</div>

<div class="m-0_5em">

    <div class="b-1px-solid-grey">
        <div class="text-center">
            <h2>Surat Perintah Kerja</h2>
        </div>
        <div class="grid-3-25_10_auto m-0_5em grid-row-gap-1em">
            <div>No.</div>
            <div>:</div>
            <div id="divSPKNumber" class="font-weight-bold"></div>
            <div>Tanggal</div>
            <div>:</div>
            <div id="divTglPembuatan" class="font-weight-bold"></div>
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
{{-- <div id="divItemList"></div>

PUSING NGELIAT FUNCTION YANG GUA BIKIN SENDIRI CUK
GUA BUAT MANUAL LAGI AJA DAH!
--}}

<div id="divItemList"></div>

<div id="divItemList2" class="p-1em">
    <form action="/spk/penetapan_item_selesai-db" method="POST">
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

    const data_spk_item = {!! json_encode($data_spk_item, JSON_HEX_TAG) !!};
    console.log("data_spk_item:");
    console.log(data_spk_item);

    const tgl_pembuatan = {!! json_encode($tgl_pembuatan, JSON_HEX_TAG) !!};
    console.log('tgl_pembuatan');
    console.log(tgl_pembuatan);

    const tgl_pembuatan_dmY = {!! json_encode($tgl_pembuatan_dmY, JSON_HEX_TAG) !!};
    console.log('tgl_pembuatan_dmY');
    console.log(tgl_pembuatan_dmY);

    const my_csrf = {!! json_encode($csrf, JSON_HEX_TAG) !!};

    const spk_produks = {!! json_encode($spk_produks, JSON_HEX_TAG) !!}
    console.log('spk_produks');
    console.log(spk_produks);

    var htmlSPKItem = '';
    var date_today = getDateToday();
    // console.log('date_today');
    // console.log(date_today);
    
    for (let i = 0; i < data_spk_item.length; i++) {
        /*
        htmlSPKItem: menampung element html untuk List SPK Item
        htmlDD: Dropdown pertama, nanti nya akan disisipkan ke htmlSPKItem
        htmlDD2: Dropdown kedua, nanti nya akan disisipkan ke htmlSPKItem
        */
        var htmlDD = '';
        var htmlDD2 = '';
        var jml_selesai = 0;
        var deviasi_jml = 0;
        var sisa_jml = data_spk_item[i].jumlah;

        if (typeof data_spk_item[i].deviasi_jml !== 'undefined') {
            deviasi_jml = data_spk_item[i].deviasi_jml;
        }
        
        if (typeof data_spk_item[i].jml_selesai !== 'undefined') {
            jml_selesai = data_spk_item[i].jml_selesai;
            sisa_jml = data_spk_item[i].jumlah - jml_selesai + deviasi_jml;
        }

        // Menentukan warna
        var fColor = 'tomato';

        // Menentukan tampilan Jumlah + deviasi_jml
        var divJml = `${data_spk_item[i].jumlah}`;
        if (deviasi_jml !== 0) {
            if (deviasi_jml < 0) {
                divJml += `<span>${deviasi_jml}</span>`;
            } else {
                divJml += `<span>+${deviasi_jml}</span>`;
            }
        }

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
       var htmlTahapSelesai = '';
       
       if (spk_produks[i].jmlSelesai_kapan !== null && spk_produks[i].jmlSelesai_kapan !== '') {

            var jmlSelesai_kapan_i = spk_produks[i].jmlSelesai_kapan;
            jmlSelesai_kapan_i = JSON.parse(jmlSelesai_kapan_i);

            console.log('jmlSelesai_kapan_i');
            console.log(jmlSelesai_kapan_i);

            if (jmlSelesai_kapan_i.length !== 0) {
                for (let i2 = 0; i2 < jmlSelesai_kapan_i.length; i2++) {
                    htmlTahapSelesai += `<option value='${jmlSelesai_kapan_i[i2].tahap}'>Tahap - ${jmlSelesai_kapan_i[i2].tahap}</option>`;
                }
            }
        } else {
            htmlTahapSelesai += '<option value="1">Tahap - 1</option>';
        }

        htmlDD += `
            <div>Jumlah Selesai Sementara: ${jml_selesai}</div>
            <div>Sisa Jumlah yang dapat diinput: ${sisa_jml}</div>
            <table>
                <tr><td>Deviasi(+/-)</td><td>:</td><td><input type='number' name='deviasi_jml[]' value=${deviasi_jml}></td></tr>
                <tr><td>Tambah Jml. Selesai</td><td>:</td><td><input type='number' name='tbh_jml_selesai[]' value=${sisa_jml}></td></tr>
                <tr><td>Tgl. Selesai</td><td>:</td><td><input type='date' id='date_today-${i}' name='tgl_selesai[]' value='${date_today}'></td></tr>
                <tr><td><input type='hidden' name='spk_produk_id[]' value='${spk_produks[i].id}' disabled></td></tr>
            </table>
            <table>
                <tr><td><input type='checkbox' class='dd_checkbox2' id='ddCheckbox2-${i}' name='tahapan[]' value='${i}' onclick='isChecked(${params_dd2});'></td><td>Anda ingin tambahkan tahapan?</td></tr>
            </table>
        `;

        htmlDD2 += `
            <table>
                <tr><td><select name='tahap-${i}'>${htmlTahapSelesai}</select></td></tr>
                <tr><td>Tgl. Selesai</td><td>:</td><td><input type='date' id='date_today-${i}' name='tgl_selesai_dd-${i}' value='${date_today}'></td></tr>
            </table>
        `;

        /*
        Parameter untuk Dropdown pertama yang akan di kirim ke function isChecked
        */
        
        var params_dd = {
            id_dd: `#DD-${i}`,
            class_checkbox: ".dd",
            id_checkbox: `#ddCheckbox-${i}`,
            id_button: `#btnSelesai_new`,
            to_uncheck: params_dd2,
        }

        params_dd = JSON.stringify(params_dd);

        htmlSPKItem += `
            <tr class='bb-1px-solid-grey'>
                <td style='color:${fColor};font-weight:bold;font-size:1em;padding-bottom:1em;padding-top:1em;' class=''>${data_spk_item[i].nama}</td>
                <td style='color:green;font-weight:bold;'>${divJml}</td>
                <td><input type='checkbox' id='ddCheckbox-${i}' class='dd' onclick='isChecked(${params_dd});'></td>
            </tr>
            <tr id='DD-${i}' style='display:none'><td colspan=3>${htmlDD}</td></tr>
            <tr id='DD2-${i}' style='display:none'><td colspan=3>${htmlDD2}</td></tr>
        `;
        
    }

    $('#tableItemList').html(htmlSPKItem);

    // var produk = <-?= json_encode($array_produk); ?>;
    // console.log(produk);

    // var daftarSPKCPNota = <-?= json_encode($daftarSPKCPNota); ?>;
    // console.log("daftarSPKCPNota:");
    // console.log(daftarSPKCPNota);
    // var statusNota = "";
    // var jumlahSisa = 0;
    // var daftarNota = <-?= json_encode($daftarNota); ?>;
    // console.log("daftarNota");
    // console.log(daftarNota);

    $jmlTotalSPK = 0;
    var element_to_toggle = "";

    // for (var i = 0; i < data_spk_item.length; i++) {
    //     var action = "";
    //     element_to_toggle = [{
    //         id: `#divOpsiSPKItem-${i}`,
    //         time: 300
    //     }];

    //     element_to_toggle = JSON.stringify(element_to_toggle);

    //     // menentukan background color untuk membedakan mana yang udah dibuat nota dan mana yang belum
    //     var bgColor = "";
    //     var jumlahSudahInputKeNota = 0;
    //     if (daftarSPKCPNota.length <= 0) {
    //         statusNota = "EMPTY";
    //     }
    //     console.log("statusNota:");
    //     console.log(statusNota);

    //     if (statusNota != "EMPTY") {
    //         for (var j = 0; j < daftarSPKCPNota[i].length; j++) {
    //             jumlahSudahInputKeNota += parseInt(daftarSPKCPNota[i][j].jumlah);
    //         }
    //         jumlahSisa = parseInt(data_spk_item[i].jumlah) - jumlahSudahInputKeNota
    //     }

    //     console.log("jumlahSisa:")
    //     console.log(jumlahSisa);
    //     if (jumlahSisa == 0) {
    //         fColor = "color-red";
    //     } else if (jumlahSisa >= 0 && jumlahSisa < data_spk_item[i].jumlah) {
    //         fColor = "color-blue-purple";
    //     }



    //     var ktrg = data_spk_item[i].ktrg;
    //     if (ktrg == null) {
    //         ktrg = "";
    //     } else {
    //         ktrg = ktrg.replace(new RegExp('\n?\r', 'g'), '<br />');
    //     }



    //     htmlSPKItem = htmlSPKItem +
    //         `<div>
    //         <div class='divItem p-0_5em grid-3-75_15_10 pt-0_5em pb-0_5em bb-1px-solid-grey'>
    //             <div class='divItemName ${fColor}'>
    //                 <span style="font-weight: bold;">${produk[i].nama_lengkap}</span>
    //             </div>
    //             <div class='grid-1-auto'>
    //                 <div class='color-green justify-self-right font-size-1_2em'>
    //                     ${data_spk_item[i].jumlah}
    //                 </div>
    //                 <div class='color-grey justify-self-right'>Jumlah</div>
    //             </div>
    //             <input class="checkboxSPKCP" type="checkbox" name="item[${i}]" value="${data_spk_item[i].id}" onclick="isChecked();">
    //         </div>

    //         </div>
    //         `;

    //     $jmlTotalSPK = $jmlTotalSPK + parseFloat(data_spk_item[i].jumlah);
    // }

    // console.log($jmlTotalSPK);

    // setTimeout(function() {
    //     if ($jmlTotalSPK !== 0) {
    //         $('#divJmlTotal2').html($jmlTotalSPK);
    //         $('#divJmlTotal').show();
    //     }

    // }, 1000);

    $('#divSPKNumber').html(spk.id);
    $('#divTitleDesc').html(spk.ktrg);
    // $('#divItemList').html(htmlSPKItem);
    $('#divTglPembuatan').html(tgl_pembuatan_dmY);
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


<?php
/*
Coba cari tau, ini buat apa ya?
*/
// $sql = "SELECT produk.nama_lengkap, spk_contains_produk.id, spk_contains_produk.id_produk, spk_contains_produk.jumlah, spk_contains_produk.jml_selesai, spk_contains_produk.deviasi_jml, spk_contains_produk.status
// FROM produk INNER JOIN spk_contains_produk ON
// produk.id=spk_contains_produk.id_produk AND spk_contains_produk.id_spk=$id_spk";
// $res = $mysqli->query($sql);
// $dSPKCPProduk = array();
// while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
//     array_push($dSPKCPProduk, $row);
// }
?>

<script>
    // var id_spk = " $id_spk; ?>";
    // var dSPKCPProduk =  json_encode($dSPKCPProduk); ?>;
    // console.log("dSPKCPProduk");
    // console.log(dSPKCPProduk);

    // CREATE LIST Checkbox Dropdown
    /*
    variable object adalah json, yang mana dari json tersebut ingin kita buat list dropdown
    dengan input2 yang bisa di isi.
    */
    var checkboxConfirmListParams = {
        object: data_spk_item,
        first_line_keys: [{
            name: "nama",
            color: {
                requirement: {
                    key: "status",
                    value: ["PROSES", "SELESAI"],
                    color: ["tomato", "slateblue"]
                }
            }
        }, {
            name: "jumlah",
            color: "green",
            class: "jmlJmlSelesai"
        }],
        checkbox: {
            name: "produk_id",
            value: "produk_id"
        },
        button: {
            id: "btnSelesai",
            label: "Konfirmasi Selesai"
        },
        dd_input_title: {
            title: "Jumlah Selesai Sementara: ",
            key: "jml_selesai" // ambil dari object yang berkaitan dengan key=jml_selesai
        },
        dd_input: [{
            type: "number",
            label: "Deviasi(-/+)",
            name: "deviasi_jml",
            value: {
                key: "deviasi_jml"
            }
        }, {
            type: "number",
            label: "Jml. Selesai",
            name: "jml_selesai",
            class: "jml_selesai",
            value: {
                key: "jml_selesai"
            }
        }, {
            type: "date",
            label: "Tgl. Selesai",
            name: "tgl_selesai",
            value: tgl_pembuatan
        }, {
            type: "hidden",
            // label: "Jml. Selesai",
            name: "jumlah",
            value: {
                key: "jumlah"
            }
        }, {
            type: "hidden",
            name: "spk_produk_id",
            value: {
                key: "spk_produk_id"
            }
        }],
        form: {
            action: "/spk/penetapan_item_selesai-db",
            method: "post",
            input: [{
                type: "hidden",
                name: "spk_id",
                value: spk.id
            }]
        },
        container: {
            id: "divItemList"
        }
    };


    // FUNGSI SEBELUMNYA:
    // createCheckboxConfirmList(checkboxConfirmListParams, my_csrf);
    // RUN: END
    // var htmlCheckboxList = createCheckboxConfirmList(checkboxConfirmListParams);
    // var containerCheckboxList = document.createElement('div');
    // containerCheckboxList.classList = "m-1em";
    // containerCheckboxList.innerHTML = htmlCheckboxList;

    // document.getElementById('divItemList').appendChild(containerCheckboxList);

    // END: CREATE LIST

    var ketJumlah = document.querySelectorAll(".jmlJmlSelesai");
    // setTimeout(() => {
    var dInputJmlSelesai = document.querySelectorAll('.jml_selesai');
    console.log("dInputJmlSelesai");
    console.log(dInputJmlSelesai);
    // }, 500);
    for (var i = 0; i < ketJumlah.length; i++) {
        if (typeof data_spk_item[i].deviasi_jml !== 'undefined') {
            const jmlTotal = parseInt(data_spk_item[i].jumlah) + parseInt(data_spk_item[i].deviasi_jml);
            const jmlAwal = parseInt(data_spk_item[i].jumlah);
            if (jmlTotal !== jmlAwal) {
                var deviasi_jml = data_spk_item[i].deviasi_jml;
                if (deviasi_jml > 0) {
                    deviasi_jml = `+${deviasi_jml}`;
                }
                ketJumlah[i].innerHTML += `
                    <div style="font-weight:bold;text-align:right;color:salmon;display:inline-block;">${deviasi_jml}</div>
                `;
            }
            // MENENTUKAN VALUE jml_selesai
            dInputJmlSelesai[i].value = jmlTotal;
        }
    }

    /*METHODE U. RELOAD PAGE*/
    const reload_page = {!! json_encode($reload_page, JSON_HEX_TAG) !!};
    reloadPage(reload_page);

</script>
@endsection