<script>
    const tankpads = {!! json_encode($tankpads, JSON_HEX_TAG) !!};
    console.log(tankpads);

    document.getElementById("tipe").value = "tankpad";
    document.getElementById("div_option_jml").innerHTML = box_jml;
    document.getElementById("div_input_jml").innerHTML = input_jml;
    document.getElementById("div_option_ktrg").innerHTML = box_ktrg;
    document.getElementById("div_ta_ktrg").innerHTML = ta_ktrg;

    const available_options = ["box_jml", "box_ktrg"];

    $("#tankpad").autocomplete({
        source: tankpads,
        select: function(event, ui) {
            // console.log(ui.item);
            $("#tankpad_id").val(ui.item.id);
            $("#tankpad_harga").val(ui.item.harga);
            // show_select_variasi();
            // show_options(available_options);
        }
    });


</script>
