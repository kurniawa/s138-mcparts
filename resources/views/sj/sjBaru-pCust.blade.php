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
    <form action="/sj/sjBaru-pCust-DB" method="POST" name="form_pCust_pNota">
        @csrf
        {{-- <input type='checkbox' name='main_checkbox' id='main_checkbox' onclick="checkAll(this.id, 'dd');"> Pilih Semua --}}
        <table style="width:100%;" id="tableItemList"></table>

        <div id="divMarginBottom" style="height: 20vh;"></div>

        <button id="btnKonfirmasi" type="submit" class="btn-warning-full" style="display:none">Konfirmasi</button>
    </form>
</div>

<div id="divMarginBottom" style="height: 20vh;"></div>

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
            <td class='p-2'>
                <input type='checkbox' name='' value='' onclick='showBtnKonfirmasi(this.className, "iptHidden_notaID-${i0}")' class='c-boxPNota-${i0}'>
                <input type="hidden" name="nota_id[]" value=${notas[i_checkboxNota].id} class='iptHidden_notaID-${i0}' disabled>
            </td>
            <td class='p-2'>${notas[i_checkboxNota].no_nota}</td>
            <td class='p-2'>Harga.T: Rp. ${formatHarga(notas[i_checkboxNota].harga_total.toString())},-</td>
            <td class='p-2' onclick='showNotaItem("DD2-${i0}${i_checkboxNota}", "ddImgRotate-${i0}${i_checkboxNota}")'><img class='w-0_7em' src='/img/icons/dropdown.svg' id='ddImgRotate-${i0}${i_checkboxNota}'></td>
            </tr>
            <tr id='DD2-${i0}${i_checkboxNota}' style='display:none'>
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
            <tr class='bb-1px-solid-grey DD'><td><input id='rad_pCust-${i0}' type='radio' name='pCust' value='${cust.id}' onclick='pNota_showDD("DD-${i0}", ${i0});'> <label for='rad_pCust-${i0}'>${cust.nama}</label></td></tr>
            <!-- <tr class='bb-1px-solid-grey'><td><input type='radio' name='pCust' value='test'>test</td></tr> -->
            <tr id='DD-${i0}' style='display:none'><td colspan=3>${htmlDD}</td></tr>
            <tr class='bb-1px-solid-grey'><td></td></tr>
        `;
        
            // <tr id='DD2-${i}' style='display:none'><td colspan=3>${htmlDD2}</td></tr>
    }

    $('#tableItemList').html(htmlCusts);

    var radio_pCust = document.form_pCust_pNota.pCust;
    console.log('radio_pCust');
    console.log(radio_pCust);

    function pNota_showDD(DD_id, DD_index) {
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
        // var nota = JSON.parse(custs_notas[DD_index].notas);
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