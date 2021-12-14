<script>
    const mode = {!! json_encode($mode, JSON_HEX_TAG) !!};
    const tipe = {!! json_encode($tipe, JSON_HEX_TAG) !!};
    const tankpads = {!! json_encode($tankpads, JSON_HEX_TAG) !!};
    const att_tp = {!! json_encode($att_tp, JSON_HEX_TAG) !!};
    console.log(tankpads);
    console.log(tankpads);

    document.getElementById('container_property_spk_item').innerHTML = `
        <div id='div_pilih_tp'></div>
    `;

    const div_pilih_tp = `
    <br>
    Pilih Tankpad:
    <div>
    <input type='text' id='tankpad' name='tankpad' class='input-normal' style='border-radius:5px;'>
    <input type='hidden' id='tankpad_id' name='tankpad_id'>
    <input type='hidden' id='tankpad_harga' name='tankpad_harga'>
    </div>
    `;

    document.getElementById("tipe").value = "tankpad";
    document.getElementById("div_pilih_tp").innerHTML = div_pilih_tp;
    document.getElementById("div_option_jml").innerHTML = box_jml;
    document.getElementById("div_input_jml").innerHTML = input_jml;
    document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
    document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

    /*
    Yang menjadi perbedaan antara SPK Baru atau Edit adalah:
    -judul halaman
    -input yang sudah terisi di mode edit

    PENGISIAN INPUT
    membandingkan antara tankpad_id dengan id pada label tankpads
    */
    var judul = '<h2>';
    if (mode === 'SPK_BARU') {
        judul += `SPK Baru - `;
    } else if (mode === 'edit') {
        judul += 'Edit SPK Item - ';
        const spk_item = {!! json_encode($spk_item, JSON_HEX_TAG) !!};
        console.log('spk_item');
        console.log(spk_item);
        const produk = {!! json_encode($produk, JSON_HEX_TAG) !!};
        console.log('produk');
        console.log(produk);
        const produk_props = JSON.parse(produk.properties);
        console.log('produk_props');
        console.log(produk_props);

        for (let i = 0; i < tankpads.length; i++) {
            if (tankpads[i].id === produk_props.tankpad_id) {
                document.getElementById('tankpad').value = tankpads[i].label;
                document.getElementById('tankpad_id').value = tankpads[i].id; 
                document.getElementById('tankpad_harga').value = tankpads[i].harga;
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
    judul += 'Tankpad</h2>';
    document.getElementById('judul').innerHTML = judul;

    const available_options = ["box_jml", "box_ktrg"];

    $("#tankpad").autocomplete({
        source: tankpads,
        select: function(event, ui) {
            // console.log(ui.item);
            $("#tankpad_id").val(ui.item.id);
            $("#tankpad_harga").val(ui.item.harga);
            // show_select_variasi();
            show_options(available_options);
        }
    });


</script>
