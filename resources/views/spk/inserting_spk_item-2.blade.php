@extends('layouts/main_layout')

@section('content')
    
<form action="/spk/inserting_item-db" method="POST" id="form_spk_item" class="m-1em" name="form_spk_item">
@csrf
    <div>
        <h2 id="judul"></h2>
    </div>

    <div id="container_property_spk_item"></div>
    <div id="container_properti_spk_item_general">
        {{-- {!! $element_properties !!} --}}
    </div>
    <div style="height: 30vh"></div>

    <br><br>


    <div id="divAvailableOptions" class="position-fixed bottom-5em w-calc-100-1em">
        Available options:
        <div id="container_options">
            {{-- {!! $available_options !!} --}}
        </div>

    </div>
    <div class="position-fixed bottom-0_5em w-calc-100-2em">
        <button type="submit" id="bottomDiv" class="btn-warning-full grid-1-auto">

            <span id="btn_submit" class="justify-self-center font-weight-bold">TAMBAH ITEM KE SPK</span>

        </button>
    </div>
    <input id="tipe" type="hidden" name="tipe">
    <input id="mode" type="hidden" name="mode">
    <div id="container_input_hidden"></div>
</form>

<script>
    var props_alternate_jml = {
        btn_hide: "close_jml",
        btn_show: "box_jml",
        id: "div_input_jml",
    };
    props_alternate_jml = JSON.stringify(props_alternate_jml);

    var props_alternate_ktrg = {
        btn_hide: "close_ktrg",
        btn_show: "box_ktrg",
        id: "div_ta_ktrg",
        type: "textarea",
        opt_to_reset: "ktrg",
    };
    props_alternate_ktrg = JSON.stringify(props_alternate_ktrg);

    // BUTTON OPTIONS
    const box_jml = `<div id="box_jml" class="box" onclick='alternate_show(this.id, ${props_alternate_jml});'>Jumlah</div>`;
    const box_ktrg = `<div id="box_ktrg" class="box" onclick='alternate_show(this.id, ${props_alternate_ktrg});'>+ Ktrgn</div>`;
    // END BUTTON OPTIONS

    // ELEMENT TO ALTERNATE SHOW
    const input_jml =
        `<div id="input_jml">
            Jumlah:
            <input id='jumlah' type="number" name="jumlah" min="0" step="1" placeholder="Jumlah" class="p-0_5em" style="border-radius:5px;">
        </div>`;

    const ta_ktrg =
        `<div id="ta_ktrg">
            <div>Keterangan <span style="color:grey">(opsional)</span>:</div>
            <div class='text-right'><span id="close_ktrg" class='ui-icon ui-icon-closethick' onclick='alternate_show(this.id, ${props_alternate_ktrg});'></span></div>
            <textarea id='ktrg' class="pt-1em pl-1em text-area-mode-1" name="ktrg" id="taDesc" placeholder="Keterangan"></textarea>
        </div>`;
    // END ELEMENT TO ALTERNATE SHOW

    document.getElementById('container_properti_spk_item_general').innerHTML = `
        <div style='display:none;' class='mt-1em' id='div_ta_ktrg'></div>
        <div style='display:none;' class='mt-1em' id='div_input_jml'></div>
    `;

    document.getElementById('container_options').innerHTML = `
        <div style='display:inline-block' id='div_option_jml'></div>
        <div style='display:inline-block' id='div_option_ktrg'></div>
    `;
</script>
@if ($tipe==='kombi')
    @include('spk.js_editing_f_detail_kombi')

@elseif($tipe === 'varia')
    @include('spk.js_editing_f_detail_varia')

@elseif($tipe === 'spjap')
@include('spk.js_editing_f_detail_spjap')
    {{-- @if ($mode === 'edit')
    @else
    @include('spk.js_inserting_spjap')
    @endif --}}
    
@elseif($tipe === 'std')
    {{-- @include('spk.js_inserting_std') --}}
    @include('spk.js_editing_f_detail_std')

@elseif($tipe === 'tankpad')
    @include('spk.js_inserting_tankpad')

@elseif($tipe === 'busastang')
    @include('spk.js_inserting_busastang')

@elseif($tipe === 'stiker')
    @include('spk.js_inserting_stiker')

@endif

<script>

    function show_options(available_options) {
        // console.log(available_options);

        available_options.forEach(option => {
            document.getElementById(option).style.display = "block";
        });
    }

    /*
    Jadi di fungsi alternate_show ini saya maunya selain dia hide elemen, dia akan juga reset value dari
    input atau select ataupun textarea yang di hide. Reset Value jadi kosong/string kosong ""
    */
    function alternate_show(clicked, props) {
        console.log(props);
        if (clicked === props.btn_show) {
            // console.log("show");
            // console.log(props.id);
            document.getElementById(props.id).style.display = "block";
            document.getElementById(props.btn_show).style.display = "none";
        } else if (clicked === props.btn_hide) {
            // console.log('hide');
            document.getElementById(props.id).style.display = "none";
            document.getElementById(props.btn_show).style.display = "block";
            if (props.type === 'textarea') {
                document.getElementById(props.opt_to_reset).value = '';
            } else if (props.type === 'select') {
                console.log('opt_to_reset:');
                console.log(props.opt_to_reset);
                document.getElementById(props.opt_to_reset).selectedIndex = 0;   
            }

        }
    }
</script>


@endsection


