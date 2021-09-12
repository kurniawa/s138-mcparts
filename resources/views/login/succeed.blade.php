@extends('layouts.main_layout')

@section('content')

@if (session()->has('success'))
    
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session('success') }}</strong> You should check in on some of those fields below.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@else
    
@endif

<div class="mt-2em text-center">
    <button id='backToSPK' class="btn-1 d-inline-block bg-color-orange-1" onclick="windowHistoryGo(-2);">Kembali</button>
</div>
@endsection