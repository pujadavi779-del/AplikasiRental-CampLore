@extends('admin.admin')

@section('title', 'Data Pembayaran Rental')

@section('content')

<div class="fixed top-5 right-6 z-40 left-[calc(16rem+24px)] max-sm:left-6">
    @include('admin.navbar', [
        'NavParent' => 'Managemen Rental',
        'section'   => 'Pembayaran'
    ])
</div>

