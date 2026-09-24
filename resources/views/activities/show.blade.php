@extends('layouts.app')

@section('content')

    @if ($errors->has('status'))
    <p style="color:red;">{{ $errors->first('status') }}</p>
    @endif
    
    <p><a href="{{ route('activities.index') }}">&larr; Kembali ke daftar</a></p>

    <h1>{{ $activity->title }}</h1>
    <p>Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
    <p>Kategori: {{ $activity->category }}</p>
    <p>Status: {{ $activity->status }}</p>
    <p>Deskripsi:</p>
    <p>{{ $activity->description ?? 'Tidak ada deskripsi.' }}</p>

    <a href="{{ route('activities.edit', $activity) }}">Ubah</a>

    <form method="POST" action="{{ route('activities.destroy', $activity) }}" onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit">Hapus</button>
    </form>
@endsection