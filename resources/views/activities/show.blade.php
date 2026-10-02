@extends('layouts.app')

@section('content')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color:red;">{{ $error }}</p>
        @endforeach
    @endif

    @if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <p>
        <a href="{{ route('activities.index') }}">&larr; Kembali ke daftar</a>
    </p>

    <h1>{{ $activity->title }}</h1>
    <p>Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
    <p>Lokasi: {{ $activity->location ?? '-' }}</p>
    <p>Kapasitas: {{ $activity->capacity ?? '-' }}</p>
    <p>Kategori: {{ $activity->category->name }}</p>
    <p>Status: {{ $activity->status }}</p>
    <p>Pendaftar: {{ $activity->registered_count }} / {{ $activity->capacity }}</p>

    <p>Deskripsi:</p>
    <p>{{ $activity->description ?? 'Tidak ada deskripsi.' }}</p>

    <a href="{{ route('activities.edit', $activity) }}">Ubah</a>

    <form
        method="POST"
        action="{{ route('activities.destroy', $activity) }}"
        onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')"
        style="display:inline"
    >
        @csrf
        @method('DELETE')
        <button type="submit">Hapus</button>
    </form>

    @if ($activity->status === 'draft')
        <form
            method="POST"
            action="{{ route('activities.publish', $activity) }}"
            style="display:inline"
        >
            @csrf
            @method('PATCH')
            <button type="submit">Publish</button>
        </form>
    @endif

    @if ($activity->status === 'published')
        <form
            method="POST"
            action="{{ route('activities.complete', $activity) }}"
            style="display:inline"
        >
            @csrf
            @method('PATCH')
            <button type="submit">Complete</button>
        </form>
    @endif

    <h2>Form Pendaftaran</h2>

    <form
        method="POST"
        action="{{ route('activities.registrations.store', $activity) }}"
    >
        @csrf

        <label for="participant_name">Nama Peserta</label>
        <input
            type="text"
            id="participant_name"
            name="participant_name"
            value="{{ old('participant_name') }}"
        >

        <br><br>

        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
        >

        <br><br>

        <button type="submit">Daftar</button>
    </form>

@endsection