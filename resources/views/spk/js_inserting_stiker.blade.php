<script>
    const stikers = {!! json_encode($stikers, JSON_HEX_TAG) !!};
    console.log(stikers);

    document.getElementById("tipe").value = "stiker";
    document.getElementById("div_option_jml").innerHTML = box_jml;
    document.getElementById("div_input_jml").innerHTML = input_jml;
    document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
    document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

    const available_options = ["box_jml", "box_ktrg"];

    $("#stiker").autocomplete({
        source: stikers,
        select: function(event, ui) {
            // console.log(ui.item);
            $("#stiker_id").val(ui.item.id);
            $("#stiker_harga").val(ui.item.harga);
            // show_select_variasi();
            show_options(available_options);
        }
    });


</script>
