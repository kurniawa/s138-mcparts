@extends('layouts/main_layout')

@section('content')
    
<article>
    <h1>Laravel Vapor</h1>
    <h2>Requirement: composer.json</h2>
    <p>
        Kita buka file aplikasi kita pada code editor. Kita buka composer.json
        <div style="font-size:0.8em;background-color:lightgrey">
            "require": {<br>
                <div style="margin-left: 1rem;">
                    ...<br>
                    "php": "^7.3|^8.0"<br>
                    "laravel/framework": "^6.0"<br>
                    ...<br>
                </div>
            }
        </div>
        Maksud dari composer.json diatas adalah, bahwa untuk menggunakan vapor,
        maka kita perlu menggunakan php versi 7.3 keatas dan laravel framework nya juga versi 6.0 atau lebih.
        Coba saja cek composer.json kita, apakah sudah sesuai atau belum.
    </p>
    <h2>AWS Account</h2>
    <p>Nantinya Vapor memang harus di link dengan AWS Account kita, oleh karena itu nantinya kita juga perlu untuk membuat AWS Account.</p>
    <h2>Membuat Vapor Account</h2>
    <p>
        Kunjungi website vapor, disana kita buat account terlebih dahulu dengan pilih tombol <button class="btn btn-primary">Sign Up Now</button>.
        Disana form Sign Up, kita input Nama, Email dan Password.
    </p>

</article>

<style>
    article {
        width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
</style>

@endsection