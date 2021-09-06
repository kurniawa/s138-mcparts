@extends('layouts/main_layout')

{{-- @extends('layouts/navbar') --}}

@section('content')

<div id="homeScreen">
    <div id="gridMenu">
        <div class="gridMenuItem">
            <a href="/spk" class="menuIcons">
                <img src="img/icons/pencil.svg" alt="Icon SPK">
                <div>
                    SPK
                </div>
            </a>
        </div>


        <div class="gridMenuItem">
            <a class="menuIcons" href="07-01-nota.php">
                <img src="img/icons/invoice_2.svg" alt="Icon SPK">
                <div>
                    Nota
                </div>
            </a>
        </div>
        <div class="gridMenuItem">
            <a class="menuIcons" href="08-01-surat-jalan.php">
                <img src="img/icons/letter.svg" alt="Icon SPK">
                <div>
                    Surat<br>Jalan
                </div>
            </a>
        </div>
        <div class="gridMenuItem">
            <a href="05-01-ekspedisi.php" class="menuIcons">
                <img src="img/icons/truck_2.svg" alt="Icon SPK">
                <div>
                    Ekspedisi
                </div>
            </a>
        </div>
        <div class="gridMenuItem">
            <a href="pelanggan" class="menuIcons">
                <img src="img/icons/boy.svg" alt="Icon SPK">
                <div>
                    Pelanggan
                </div>
            </a>
        </div>
        <div class="gridMenuItem">
            <div class="menuIcons">
                <img src="img/icons/stok_barang.svg" alt="Icon SPK">
            </div>
            Database<br>
            Stok
        </div>
        <div class="gridMenuItem">
            <a href="06-01-produk.php" class="menuIcons">
                <img src="img/icons/products.svg" alt="Icon SPK">
                <div>Produk</div>
            </a>
        </div>
        <div class="gridMenuItem">
            <div class="menuIcons">
                <img src="img/icons/paper-roll.svg" alt="Icon SPK">
            </div>
            Bahan<br>
            Baku
        </div>
        <div class="gridMenuItem">
            <a href="/about" class="menuIcons">
                <img src="img/icons/info.svg" alt="Icon SPK">
                <div>Info Icons/<br>About</div>
            </a>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #ffb800;
    }

    #homeScreen {
        margin: 1em;
        padding: 1em;
        background-color: white;
    }

    #gridMenu {
        display: grid;
        grid-template-columns: auto auto auto;
        grid-row-gap: 2em;
    }

    .gridMenuItem {
        text-align: center;
    }

    .menuIcons>img {
        object-fit: cover;
        width: 3em;
    }

    #containerErrorReport {
        margin: 1em;
        padding: 1em;
        border: 2px solid red;
        background: rgba(255, 0, 0, 0.5);
    }

    #containerSucceedReport {
        margin: 1em;
        padding: 1em;
        border: 2px solid green;
        background: rgba(63, 191, 63, 0.5);
    }
</style>
    
@endsection
