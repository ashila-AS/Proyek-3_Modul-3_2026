@extends('layouts.app')

@section('content')
    <p><a href="{{ route('activities.show', $activity) }}">&larr; Kembali ke detail</a></p>

    <h1>Ubah Kegiatan</h1>

    <form method="POST" action="{{ route('activities.update', $activity) }}">
        @csrf
        @method('PUT')
        @include('activities._form')
        <button type="submit">Simpan Perubahan</button>
    </form>
@endsection