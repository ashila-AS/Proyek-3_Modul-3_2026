@extends('layouts.app')

@section('content')
    <h1>Daftar Kegiatan</h1>
    
    <form method="GET" action="{{ route('activities.index') }}">
    <label for="status">Filter Status:</label>

    <select name="status" id="status" onchange="this.form.submit()">
        <option value="">Semua</option>
        <option value="Planned" {{ $status === 'Planned' ? 'selected' : '' }}>Planned</option>
        <option value="Ongoing" {{ $status === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
        <option value="Done" {{ $status === 'Done' ? 'selected' : '' }}>Done</option>
    </select>
    </form>

    <p><a href="{{ route('activities.create') }}">+ Tambah Kegiatan</a></p>

    @forelse ($activities as $activity)
        <article class="card">
            <h2>
                <a href="{{ route('activities.show', $activity) }}">
                    {{ $activity->title }}
                </a>
            </h2>
            <p>{{ $activity->activity_date->format('d M Y') }}</p>
            <p>Kategori: {{ $activity->category }}</p>
            <p>Status: {{ $activity->status }}</p>
        </article>
    @empty
        <p>Belum ada kegiatan.</p>
    @endforelse
@endsection