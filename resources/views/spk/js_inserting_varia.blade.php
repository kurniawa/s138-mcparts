<script>
    const mode = {!! json_encode($mode, JSON_HEX_TAG) !!};
    const att_varia = {!! json_encode($att_varia, JSON_HEX_TAG) !!};
    console.log(att_varia);
    if (mode === 'edit') {
        var element_properties = `
        <div>Pilih Bahan:</div>
        <input type="text" id="bahan" name="bahan" class="input-normal" style="border-radius:5px;">
        <input type="hidden" id="bahan_id" name="bahan_id">
        <input type="hidden" id="bahan_harga" name="bahan_harga">
        `;

        var html_available_options = `
        <div style='display:inline-block' id='div_option_jml'></div>
        <div style='display:inline-block' id='div_option_ktrg'></div>
        `;

    }
    // const tankpads = json_encode($tankpads, JSON_HEX_TAG);
    // console.log(tankpads);

    document.getElementById("tipe").value = "varia";
    document.getElementById("div_option_jml").innerHTML = box_jml;
    document.getElementById("div_input_jml").innerHTML = input_jml;
    document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
    document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

    const available_options = ["box_jml", "box_ktrg"];

    $("#bahan").autocomplete({
        source: att_varia['label_bahans'],
        select: function(event, ui) {
            // console.log(ui.item);
            $("#bahan_id").val(ui.item.id);
            $("#bahan_harga").val(ui.item.harga);
            // show_select_variasi();
            // show_options(available_options);
        }
    });


</script>
