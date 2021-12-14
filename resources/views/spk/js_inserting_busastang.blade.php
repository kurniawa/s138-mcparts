<script>
    const mode = {!! json_encode($mode, JSON_HEX_TAG) !!};
    const tipe = {!! json_encode($tipe, JSON_HEX_TAG) !!};
    const busastangs = {!! json_encode($busastangs, JSON_HEX_TAG) !!};
    const att_busastang = {!! json_encode($att_busastang, JSON_HEX_TAG) !!};

    console.log(busastangs);

    document.getElementById('container_property_spk_item').innerHTML = `<div id='div_pilih_busastang'></div>`;

    const element_properties = `
    <br>
    <div id='div_input_busastang'>
    <input type='text' id='busastang' name='busastang' class='input-normal' style='border-radius:5px;' value='Busa-Stang'>
    <input type='hidden' id='busastang_id' name='busastang_id'>
    <input type='hidden' id='busastang_harga' name='busastang_harga'>
    </div>
    `;

    document.getElementById("tipe").value = "busastang";
    document.getElementById('div_pilih_busastang').innerHTML = element_properties;
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
        judul += 'SPK Baru - ';
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

        for (let i = 0; i < busastangs.length; i++) {
            if (busastangs[i].id === produk_props.busastang_id) {
                document.getElementById('busastang').value = busastangs[i].label;
                document.getElementById('busastang_id').value = busastangs[i].id; 
                document.getElementById('busastang_harga').value = busastangs[i].harga;
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
    judul += 'Busastang</h2>';
    document.getElementById('judul').innerHTML = judul;

    const available_options = ["box_jml", "box_ktrg"];

    $('#div_ta_ktrg').show();
    $('#div_input_jml').show();

    if (busastangs.length === 1) {
        document.getElementById('busastang').value = busastangs[0].value;
        document.getElementById('busastang').readOnly = true;
        document.getElementById('busastang_id').value = busastangs[0].id;
        document.getElementById('busastang_harga').value = busastangs[0].harga;
    }

</script>
