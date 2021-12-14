<script>
    const mode = {!! json_encode($mode, JSON_HEX_TAG) !!};
    const att_kombi = {!! json_encode($att_kombi, JSON_HEX_TAG) !!};
    const tipe = {!! json_encode($tipe, JSON_HEX_TAG) !!};
    const kombis = {!! json_encode($kombis, JSON_HEX_TAG) !!};
    console.log('att_kombi');
    console.log(att_kombi);

    // var props_alternate_ukuran = {
    //     btn_hide: "close_ukuran",
    //     btn_show: "box_ukuran",
    //     id: "div_select_ukuran",
    //     opt_to_reset: "sel_ukuran",
    // };
    // props_alternate_ukuran = JSON.stringify(props_alternate_ukuran);

    // var props_alternate_jht = {
    //     btn_hide: "close_jht",
    //     btn_show: "box_jht",
    //     id: "div_select_jht",
    //     opt_to_reset: "sel_jahit",
    // };
    // props_alternate_jht = JSON.stringify(props_alternate_jht);

    // const box_ukuran = `<div id="box_ukuran" class="box" onclick='alternate_show(this.id, ${props_alternate_ukuran});'>+ Ukuran</div>`;
    // const box_jht = `<div id="box_jht" class="box" onclick='alternate_show(this.id, ${props_alternate_jht});'>+ Jahit</div>`;

    // const pilih_bahan = `
    //     <div>Pilih Bahan:</div>
    //     <input type="text" id="bahan" name="bahan" class="input-normal" style="border-radius:5px;">
    //     <input type="hidden" id="bahan_id" name="bahan_id">
    //     <input type="hidden" id="bahan_harga" name="bahan_harga">
    // `;
    // document.getElementById('container_property_spk_item').innerHTML = `
    //     <div id='div_pilih_bahan'></div>
    //     <div id='div_pilih_variasi'></div><br>
    //     <div id='div_select_ukuran'></div><br>
    //     <div id='div_select_jht'></div><br>
    // `;

    // document.getElementById("div_pilih_bahan").innerHTML = pilih_bahan;

    // document.getElementById('container_options').innerHTML = `
    //     <div style='display:inline-block;' id='div_box_jml'></div>
    //     <div style='display:inline-block;' id='div_box_ukuran'></div>
    //     <div style='display:inline-block;' id='div_box_jht'></div>
    //     <div style='display:inline-block;' id='div_box_ktrg'></div>
    // `;

    document.getElementById('container_property_spk_item').innerHTML = `
        <div id='div_pilih_kombi'></div>
    `;

    const pilih_kombis = `
        <div>Pilih Kombinasi:</div>
        <input type="text" id="kombi" name="kombi" class="input-normal" style="border-radius:5px;">
        <input type="hidden" id="kombi_id" name="kombi_id">
        <input type="hidden" id="kombi_harga" name="kombi_harga">
    `;

    document.getElementById("tipe").value = "kombi";
    document.getElementById("div_pilih_kombi").innerHTML = pilih_kombis;
    document.getElementById("div_option_jml").innerHTML = box_jml;
    document.getElementById("div_input_jml").innerHTML = input_jml;
    document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
    document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

    /*
    Yang menjadi perbedaan antara SPK Baru atau Edit adalah:
    -judul halaman
    -input yang sudah terisi di mode edit
    */

    /* 
    Karena ini mode edit, maka kita perlu untuk menentukan value yang sesuai dengan spk_item yang ingin
    diedit. Untuk assign value nya dibantu dengan looping. Looping ini di butuhkan karena sebelumnya
    kita tidak get kombi_id dan harga nya. Lalu fungsi autocompletenya nanti tetap akan berjalan.
    */

    var judul = '<h2>';
    if (mode === 'SPK_BARU') {
        judul += 'SPK Baru - ';
    } else if (mode === 'edit') {
        judul += 'Edit SPK Item - ';
        const spk_item = {!! json_encode($spk_item, JSON_HEX_TAG) !!};
        console.log(spk_item);
        const produk = {!! json_encode($produk, JSON_HEX_TAG) !!};
        console.log(produk);
        const produk_props = JSON.parse(produk.properties);
        console.log(produk_props);
        
        for (let i = 0; i < kombis.length; i++) {
            if (kombis[i].label === produk.nama) {
                document.getElementById('kombi').value = produk.nama;
                document.getElementById('kombi_id').value = kombis[i].id; 
                document.getElementById('kombi_harga').value = kombis[i].harga; 
            }
        }

        var jumlah = document.getElementById('jumlah');
        var ktrg = document.getElementById('ktrg');
        jumlah.value = spk_item.jumlah;
        if (typeof spk_item.ktrg !== 'undefined') {
            ktrg.value = spk_item.ktrg;
        }
        $('#div_ta_ktrg').show();
        $('#div_input_jml').show();
        var btn_submit = document.getElementById('btn_submit');
        btn_submit.textContent = 'KONFIRMASI EDIT';

        document.form_spk_item.action = '/spk/edit_spk_item-db';

        var container_input_hidden = document.getElementById('container_input_hidden');
        container_input_hidden.innerHTML = `
            <input type='hidden' name='spk_id' value=${spk_item.spk_id}>
            <input type='hidden' name='produk_id_old' value=${produk.id}>
            <input type='hidden' name='spk_produk_id' value=${spk_item.id}>
        `;

    }
    judul += 'SJ Kombinasi</h2>'

    document.getElementById('judul').innerHTML = judul;

    const available_options = ["box_jml", "box_ktrg"];

    $("#kombi").autocomplete({
        source: kombis,
        select: function(event, ui) {
            // console.log(ui.item);
            $("#kombi_id").val(ui.item.id);
            $("#kombi_harga").val(ui.item.harga);
            // show_select_variasi();
            show_options(available_options);
        }
    });

</script>
