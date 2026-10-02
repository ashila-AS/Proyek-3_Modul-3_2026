@extends('layouts.app')

@section('content')
    <h1>Daftar Kegiatan</h1>

    <form method="GET" action="{{ route('activities.index') }}">
        <input
            type="text"
            name="search"
            placeholder="Cari judul atau kode..."
            value="{{ request('search') }}"
        >

        <select name="category_id">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <select name="status">
            <option value="">Semua Status</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
        </select>

        <select name="sort">
            <option value="desc" {{ request('sort') !== 'asc' ? 'selected' : '' }}>Terbaru</option>
            <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Terlama</option>
        </select>

        <button type="submit">Terapkan</button>
        <a href="{{ route('activities.index') }}">Reset</a>
    </form>

    <p><a href="{{ route('activities.create') }}">+ Tambah Kegiatan</a></p>

    @forelse ($activities as $activity)
        <article class="card">
            <h2>
                <a href="{{ route('activities.show', $activity) }}">
                    {{ $activity->title }} ({{ $activity->code }})
                </a>
            </h2>
            <p>{{ $activity->activity_date->format('d M Y') }}</p>
            <p>Kategori: {{ $activity->category->name }}</p>
            <p>Status: {{ $activity->status }}</p>
        </article>
    @empty
        <p>Belum ada kegiatan.</p>
    @endforelse

    {{ $activities->links() }}
@endsection