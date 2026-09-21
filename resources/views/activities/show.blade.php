@extends('layouts.app')

@section('content')
    <p><a href="{{ route('activities.index') }}">&larr; Kembali ke daftar</a></p>

    <h1>{{ $activity->title }}</h1>
    <p>Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
    <p>Kategori: {{ $activity->category }}</p>
    <p>Status: {{ $activity->status }}</p>
    <p>Deskripsi:</p>
    <p>{{ $activity->description ?? 'Tidak ada deskripsi.' }}</p>
@endsection