@extends('layouts.app')

@section('content')
    <p><a href="{{ route('activities.index') }}">&larr; Kembali ke daftar</a></p>

    <h1>Tambah Kegiatan</h1>

    <form
        method="POST"
        action="{{ route('activities.store') }}"
        enctype="multipart/form-data"
    >
        @csrf

        @include('activities._form')

        <button type="submit">Simpan</button>
    </form>
@endsection