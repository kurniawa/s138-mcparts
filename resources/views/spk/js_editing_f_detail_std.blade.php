<script>
    const mode = {!! json_encode($mode, JSON_HEX_TAG) !!};
    const att_std = {!! json_encode($att_std, JSON_HEX_TAG) !!};
    const tipe = {!! json_encode($tipe, JSON_HEX_TAG) !!};
    const stds = {!! json_encode($stds, JSON_HEX_TAG) !!};
    console.log('att_std');
    console.log(att_std);

    console.log('stds');
    console.log(stds);

    document.getElementById('container_property_spk_item').innerHTML = `
        <div id='div_pilih_standar'></div>
    `;

    const pilih_stds = `
        <div>Pilih Standar:</div>
        <input type="text" id="standar" name="standar" class="input-normal" style="border-radius:5px;">
        <input type="hidden" id="standar_id" name="standar_id">
        <input type="hidden" id="standar_harga" name="standar_harga">
    `;

    document.getElementById("tipe").value = "std";
    document.getElementById("div_pilih_standar").innerHTML = pilih_stds;
    document.getElementById("div_option_jml").innerHTML = box_jml;
    document.getElementById("div_input_jml").innerHTML = input_jml;
    document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
    document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

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

        for (let i = 0; i < stds.length; i++) {
            if (`Standar ${stds[i].label}` === produk.nama) {
                document.getElementById('standar').value = produk.nama;
                document.getElementById('standar_id').value = stds[i].id; 
                document.getElementById('standar_harga').value = stds[i].harga; 
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
    judul += 'SJ Standar</h2>';
    document.getElementById('judul').innerHTML = judul;

    const available_options = ["box_jml", "box_ktrg"];

    $("#standar").autocomplete({
        source: stds,
        select: function(event, ui) {
            // console.log(ui.item);
            $("#standar_id").val(ui.item.id);
            $("#standar_harga").val(ui.item.harga);
            // show_select_variasi();
            show_options(available_options);
        }
    });

    

</script>
