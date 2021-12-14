<script>
    const mode = {!! json_encode($mode, JSON_HEX_TAG) !!};
    const att_spjap = {!! json_encode($att_spjap, JSON_HEX_TAG) !!};
    const tipe = {!! json_encode($tipe, JSON_HEX_TAG) !!};
    const spjaps = {!! json_encode($spjaps, JSON_HEX_TAG) !!};
    console.log('spjaps');
    console.log(spjaps);

    /*Untuk spjap ada tambahan variable, yakni d_bahan_a dan d_bahan_b*/
    const d_bahan_a = {!! json_encode($d_bahan_a, JSON_HEX_TAG) !!};
    const d_bahan_b = {!! json_encode($d_bahan_b, JSON_HEX_TAG) !!};

    console.log('d_bahan_a');
    console.log(d_bahan_a);
    console.log('d_bahan_b');
    console.log(d_bahan_b);

    const element_properties = `
        <br>
        Pilih Tipe Bahan:
        <div id='div_pilih_tipe_bahan'>
            <select id='tipe_bahan' name='tipe_bahan' class='form-select' onchange='setAutocomplete_D_Bahan();'>
                <option value='A'>Bahan(A)</option>
                <option value='B'>Bahan(B)</option>
            </select>
        </div>
        <br>
        Pilih Bahan:
        <div id='div_pilih_bahan'>
            <input type='text' id='bahan' name='bahan' class='input-normal' style='border-radius:5px;'>
            <input type='hidden' id='bahan_id' name='bahan_id'>
        </div>
        <br>
        <div>Pilih T.Sixpack/Japstyle:</div>
        <select id='select_spjap' name='spjap_id' class='form-select' onchange='assignSPJapIDValue(this.selectedIndex);'></select>
        <input type='hidden' id='spjap' name='spjap'>
        <input type='hidden' id='spjap_harga' name='spjap_harga'>
        `;

    document.getElementById('container_property_spk_item').innerHTML = element_properties;

    var htmlSelectSpjap = '';
    for (let i = 0; i < spjaps.length; i++) {
        htmlSelectSpjap += `
            <option value=${spjaps[i].id}>${spjaps[i].value}</option>
        `;
    }

    document.getElementById("tipe").value = "spjap";
    document.getElementById("select_spjap").innerHTML = htmlSelectSpjap;
    document.getElementById("div_option_jml").innerHTML = box_jml;
    document.getElementById("div_input_jml").innerHTML = input_jml;
    document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
    document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

    /* 
    Karena ini mode edit, maka kita perlu untuk menentukan value yang sesuai dengan spk_item yang ingin
    diedit. Untuk assign value nya dibantu dengan looping. Looping ini di butuhkan karena sebelumnya
    kita tidak get kombi_id dan harga nya. Lalu fungsi autocompletenya nanti tetap akan berjalan.

    Properti umum yang perlu di assign adalah judul.
    Lalu action dari form yang berkaitan
    Lalu textContent dari button
    */

    /*
    Untuk spjap, perlu perbandingan assign beberapa value, yakni tipe bahan dari spk_item
    bahan_id dari spk_item
    spjap_id dari spk_item
    dan properti ini harusnya dapat ditemukan pada produk properties
    */

    var judul = '<h2>';
    if (mode === 'SPK_BARU') {
        assignSPJapIDValue(0);
        judul += 'SPK Baru - ';
    } else if (mode === 'edit') {
        judul += 'Edit SPK Item - ';
        const spk_item = {!! json_encode($spk_item, JSON_HEX_TAG) !!};
        console.log('spk_item');
        console.log(spk_item);
        document.form_spk_item.action = '/spk/edit_spk_item-db';

        const produk = {!! json_encode($produk, JSON_HEX_TAG) !!};
        console.log('produk:');
        console.log(produk);
        const produk_props = JSON.parse(produk.properties);
        console.log('produk_props:');
        console.log(produk_props);

        // Untuk spjap ini dibandingkan dengan yang ada di properties nya saja.

        /*
        PEMILIHAN TIPE BAHAN
        Untuk menentukan tipe bahan, strateginya adalah memilih select option yang value nya sama dengan
        produk_props.tipe_bahan. Nanti setelah ditemukan option yang mana, maka dapat diperoleh index
        dari option tersebut. Lalu getElementById dari select dan set selectedIndex sama dengan index
        yang tadi sudah diperoleh.
        */
        var selected_tipe_bahan = document.querySelector(`#tipe_bahan option[value=${produk_props.tipe_bahan}]`);
        // console.log('selected_tipe_bahan');
        // console.log(selected_tipe_bahan);

        var index_selected_tipe_bahan = selected_tipe_bahan.index;
        // console.log('index_selected_tipe_bahan:');
        // console.log(index_selected_tipe_bahan);

        document.getElementById('tipe_bahan').selectedIndex = index_selected_tipe_bahan;

        /*
        PEMILIHAN BAHAN
        Pemilihan Bahan dapat dilakukan apabila produk_props.bahan_id dan produk_props.bahan diketahui.
        Strateginya adalah, jika tipe_bahan === A maka kita mencari array dari d_bahan_a. Jika tipe_bahan
        === B maka kita mencari dari d_bahan_b. Lalu kita akan menggunakan fungsi find() untuk mencari
        dari Array.
        */

        if (typeof produk_props.bahan_id !== 'undefined') {
            var bahan_id_selected;
            if (produk_props.tipe_bahan === 'A') {
                bahan_id_selected = d_bahan_a.find( function ({id}) {
                    id === produk_props.bahan_id;
                });
            } else {
                bahan_id_selected = d_bahan_b.find( function ({id}) {
                    id === produk_props.bahan_id;
                });
            }
            console.log('bahan_id_selected');
            console.log(bahan_id_selected);
        }

        /*
        PEMILIHAN JENIS spjap
        Ikuti petunjuk PEMILIHAN TIPE BAHAN untuk melakukan PEMILIHAN JENIS spjap ini. Artinya kita
        perlu mengakses kembali produk.props dan ambil value dari spjap_id.

        Setelah value disamakan, tentunya kita perlu set spjap dan harganya

        Menentukan harga dari produk.props['spjap_id']. Dengan diketahuinya spjap_id maka kita dapat
        mencari pada array spjaps yang memiliki id yang sesuai.
        */

        var selected_spjap = document.querySelector(`#select_spjap option[value="${produk_props.spjap_id}"]`);
        var index_selected_spjap = selected_spjap.index;
        document.getElementById('select_spjap').selectedIndex = index_selected_spjap;
        var spjap_now = spjaps.find(({ id }) => id === produk_props['spjap_id']);
        console.log('spjap_now');
        console.log(spjap_now);
        document.getElementById('spjap').value = spjap_now['label'];
        document.getElementById('spjap_harga').value = spjap_now['harga'];
        // for (let i = 0; i < spjaps.length; i++) {
        //     if (spjaps[i].id === produk_props.spjap_id) {
        //         document.getElementById('spjap').value = produk.nama;
        //         // document.getElementById('spjap_id').value = spjaps[i].id;
        //         document.getElementById('spjap_harga').value = spjaps[i].harga; 
        //     }
        // }

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

        var container_input_hidden = document.getElementById('container_input_hidden');
        container_input_hidden.innerHTML = `
            <input type='hidden' name='spk_id' value=${spk_item.spk_id}>
            <input type='hidden' name='produk_id_old' value=${produk.id}>
            <input type='hidden' name='spk_produk_id' value=${spk_item.id}>
        `;
    }

    judul += 'T. Sixpack / Japstyle</h2>';
    document.getElementById('judul').innerHTML = judul;
    const available_options = ["box_jml", "box_ktrg"];

    // Pertama kali page load kan tipe bahan sudah terpilih yang A,
    // jadi input bahan nya langsung di set daftar bahan A
    setAutocomplete_D_Bahan();

    function setAutocomplete_D_Bahan() {
        const tipe_bahan = document.getElementById('tipe_bahan').value;
        var label_bahan = new Array();
        if (tipe_bahan === 'A') {
            label_bahan = d_bahan_a;
        } else {
            label_bahan = d_bahan_b;
        }
        console.log(tipe_bahan);
        $("#bahan").autocomplete({
        source: label_bahan,
        select: function(event, ui) {
            // console.log(ui.item);
            $("#bahan_id").val(ui.item.id);
            // show_select_variasi();
            // show_options(available_options);
        }
    });
    }

    /*
    Secara default, select akan terpilih index 0.
    Oleh karena itu di assign terlebih dahulu value2 yang berkaitan dengan index 0 ini.
    */
    function assignSPJapIDValue(selectedIndex) {
        // console.log(selectedIndex);
        document.getElementById('spjap').value = spjaps[selectedIndex].value;
        document.getElementById('spjap_harga').value = spjaps[selectedIndex].harga;
    }

    

</script>
