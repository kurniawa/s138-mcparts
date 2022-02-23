@extends('layouts/main_layout')

@section('content')

<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="/img/icons/back-button-white.svg" alt="" onclick="goBack();">
</header>

{{-- <div class="container m-1em">
    <form action="/nota/notaBaru-pSPK-pItem" method="get">
        <input type="hidden" name="_token" value="{{ $csrf }}">
        <span style="font-weight:bold">Pilihan SPK yang Sebagian atau Seluruhnya SELESAI:</span><br>
        <select name="spk_id" id="selectIDSPK" class="p-1em">
            @for ($i = 0; $i < count($available_spk); $i++)
                <option value="{{ $available_spk[$i]['id'] }}">{{ $available_spk[$i]['no_spk'] }}</option>
            @endfor
        </select>
        <br><br>
        <button type="submit" class="btn-warning">Lanjut -> Pilih Item</button>
    </form>
</div> --}}

<div class="m-0_5em">

    <div>
        <h2>Pilihan SPK Berdasarkan Pelanggan</h2>
    </div>

    <div id="divTitleDesc" class="grid-1-auto justify-items-center mt-0_5em"></div>

    <input id="inputHargaTotalSPK" type="hidden">

    <!-- <div id="divJmlTotal" class="text-right p-1em">
        <div id="divJmlTotal2" class="font-weight-bold font-size-2em color-green"></div>
        <div class="font-weight-bold color-red font-size-1_5em">Total</div>
    </div> -->

</div>
<div id="divItemList2" class="p-1em">
    <form action="/nota/notaBaru-pSPK-pItem" method="GET" name="form_pCust_pSPK">
        @csrf
        {{-- <input type='checkbox' name='main_checkbox' id='main_checkbox' onclick="checkAll(this.id, 'dd');"> Pilih Semua --}}
        <table style="width:100%;" id="tableItemList"></table>

        <div id="divMarginBottom" style="height: 20vh;"></div>

        <button id="btnKonfirmasi" type="submit" class="btn-warning-full" style="display:none">Konfirmasi</button>
    </form>
</div>

<div id="divMarginBottom" style="height: 20vh;"></div>

<script>
    //  const available_spk =  {-!! json_encode($available_spk, JSON_HEX_TAG) !!};
    // console.log("available_spk");
    // console.log(available_spk);

    // const my_csrf = {-!! json_encode($csrf, JSON_HEX_TAG) !!};
    // console.log('my_csrf');
    // console.log(my_csrf);

    const pelanggan_spks = {!! json_encode($pelanggan_spks, JSON_HEX_TAG) !!};
    console.log('pelanggan_spks');
    console.log(pelanggan_spks);

    // Menentukan head dari table
    var htmlCusts = ``;
    var date_today = getDateToday();
    // console.log('date_today');
    // console.log(date_today);
    
    for (let i0 = 0; i0 < pelanggan_spks.length; i0++) {
        const cust = pelanggan_spks[i0].pelanggan;
        const reseller = pelanggan_spks[i0].reseller;
        /*
        htmlCusts: menampung element html untuk List Nota Item
        htmlDD: Dropdown pertama, nanti nya akan disisipkan ke htmlCusts
        htmlDD2: Dropdown kedua, nanti nya akan disisipkan ke htmlCusts
        */
        const spks = pelanggan_spks[i0].spks;
        /*
        variable dinamakan dengan sebutan jamak, karena bisa jadi pelanggan tersebut dibuatkan
        beberapa nota yang memang belum ada surat jalan nya.
        */
        console.log('spks:');
        console.log(spks);

        var htmlCheckboxspks = '';
        for (let i_checkboxSPK = 0; i_checkboxSPK < spks.length; i_checkboxSPK++) {
            var spkItem = JSON.parse(spks[i_checkboxSPK].data_spk_item)
            console.log('nota_item');
            console.log(spkItem);

            var htmlDataSPKItem = '';
            for (let i_spkItem = 0; i_spkItem < spkItem.length; i_spkItem++) {
                htmlDataSPKItem += `
                <tr>
                <td>${spkItem[i_spkItem].nama_nota}</td>
                <td>${formatHarga(spkItem[i_spkItem].jumlah.toString())}</td>
                </tr>
                `;
            }

            htmlCheckboxspks += `
            <tr>
            <td class='p-2'>
                <input type='checkbox' name='' value='' onclick='showBtnKonfirmasi(this.className, "iptHidden_notaID-${i0}")' class='c-boxPNota-${i0}'>
                <input type="hidden" name="spk_id[]" value=${spks[i_checkboxSPK].id} class='iptHidden_notaID-${i0}' disabled>
            </td>
            <td class='p-2'>${spks[i_checkboxSPK].no_spk}</td>
            <td class='p-2'>Jumlah.T: ${formatHarga(spks[i_checkboxSPK].jumlah_total.toString())}</td>
            <td class='p-2' onclick='showNotaItem("DD2-${i0}${i_checkboxSPK}", "ddImgRotate-${i0}${i_checkboxSPK}")'><img class='w-0_7em' src='/img/icons/dropdown.svg' id='ddImgRotate-${i0}${i_checkboxSPK}'></td>
            </tr>
            <tr id='DD2-${i0}${i_checkboxSPK}' style='display:none'>
                <td colspan=4>
                    <table style='width:100%'>
                        <tr><th>Nama</th><th>Jml.</th></tr>
                        ${htmlDataSPKItem}
                    </table>
                </td>
            </tr>
            `;
        }

        /*
        Parameter untuk Dropdown kedua yang akan di kirim ke function isChecked
        */

        var htmlDD = '';

        htmlDD += `
            <table style='width:100%'>
                ${htmlCheckboxspks}
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
        var nama_pelanggan_spk = cust.nama;
        if (reseller !== null) {
            nama_pelanggan_spk = `${reseller.nama}: ${cust.nama}`;
        }
        htmlCusts += `
            <tr class='bb-1px-solid-grey DD'><td><input id='rad_pCust-${i0}' type='radio' name='pCust' value='${cust.id}' onclick='pSPK_showDD("DD-${i0}", ${i0});'> <label for='rad_pCust-${i0}'>${nama_pelanggan_spk} - ${cust.daerah}</label></td></tr>
            <!-- <tr class='bb-1px-solid-grey'><td><input type='radio' name='pCust' value='test'>test</td></tr> -->
            <tr id='DD-${i0}' style='display:none'><td colspan=3>${htmlDD}</td></tr>
            <tr class='bb-1px-solid-grey'><td></td></tr>
        `;
        
            // <tr id='DD2-${i}' style='display:none'><td colspan=3>${htmlDD2}</td></tr>
    }

    $('#tableItemList').html(htmlCusts);

    var radio_pCust = document.form_pCust_pSPK.pCust;
    console.log('radio_pCust');
    console.log(radio_pCust);

    function pSPK_showDD(DD_id, DD_index) {
        const radioDD = document.querySelectorAll(".DD");
        for (let i_radio = 0; i_radio < radioDD.length; i_radio++) {
            // console.log('i_radio: ' + i_radio);
            // console.log('DD_index: ' + DD_index);
            if (DD_index !== i_radio) {
                $(`#DD-${i_radio}`).hide();
                var cBoxes_toUncheck = document.querySelectorAll(`#DD-${i_radio} input[type=checkbox]`);
                var inputHidden_toDisable = document.querySelectorAll(`#DD-${i_radio} input[type=hidden]`);
                for (let i_cBoxes_toUncheck = 0; i_cBoxes_toUncheck < cBoxes_toUncheck.length; i_cBoxes_toUncheck++) {
                    cBoxes_toUncheck[i_cBoxes_toUncheck].checked = false;
                    inputHidden_toDisable[i_cBoxes_toUncheck].disabled = true;
                    showBtnKonfirmasi(cBoxes_toUncheck[i_cBoxes_toUncheck].className, inputHidden_toDisable[i_cBoxes_toUncheck].className);
                }
            }            
        }
        // console.log(`DD_id: ${DD_id}; DD_index: ${DD_index}`);
        // var nota = JSON.parse(pelanggan_spks[DD_index].spks);
        // console.log(nota);
        $(`#${DD_id}`).show(300);
        // $DD.show();
    }

    function showNotaItem(idNotaItem, idRotateImg) {
        // console.log(idNotaItem);
        console.log(idRotateImg);
        $selectedElement = $(`#${idNotaItem}`);
        if ($selectedElement.css('display') === 'none') {
            $selectedElement.show(300);
            $("#" + idRotateImg).attr("src", "/img/icons/dropup.svg");
        } else {
            $selectedElement.hide();
            $("#" + idRotateImg).attr("src", "/img/icons/dropdown.svg");
        }

    }

    function showBtnKonfirmasi(c_box_class, ipt_hidden_class) {
        // console.log(c_box_class);
        var arr_indexInputToEnable = new Array();
        var c_boxes = document.querySelectorAll(`.${c_box_class}`);
        var ipt_hidden = document.querySelectorAll(`.${ipt_hidden_class}`);
        // console.log(c_boxes)
        for (let i_cBox = 0; i_cBox < c_boxes.length; i_cBox++) {
            if (c_boxes[i_cBox].checked === true) {
                arr_indexInputToEnable.push(i_cBox);
                ipt_hidden[i_cBox].disabled = false;
            }
        }
        if (arr_indexInputToEnable.length > 0) {
            document.getElementById("btnKonfirmasi").style.display = "block";
        } else {
            document.getElementById("btnKonfirmasi").style.display = "none";
        }
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
