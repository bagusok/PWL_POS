@extends('layouts.template');

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Hallo, Apakabar</h3>
            <div class="card-tools">

            </div>
        </div>
        <div class="card-body">
            <p>Selamat datang di aplikasi <b>{{ config('app.name', 'PWL Laravel Starter Code') }}</b></p>
            <p>Silahkan klik menu-menu yang ada.</p>
        </div>
    </div>
@endsection
