@extends('layouts.app')

@section('content')
    <h1>Kegiatan Terhapus</h1>

    <p><a href="{{ route('activities.index') }}">&larr; Kembali ke daftar aktif</a></p>

    @forelse ($activities as $activity)
        <article class="card">
            <h2>{{ $activity->title }} ({{ $activity->code }})</h2>
            <p>{{ $activity->activity_date->format('d M Y') }}</p>
            <p>Kategori: {{ $activity->category->name }}</p>
            <p>Dihapus pada: {{ $activity->deleted_at->format('d M Y H:i') }}</p>

            <form method="POST" action="{{ route('activities.restore', $activity) }}">
                @csrf
                @method('PATCH')
                <button type="submit">Restore</button>
            </form>
        </article>
    @empty
        <p>Tidak ada kegiatan terhapus.</p>
    @endforelse

    {{ $activities->links() }}
@endsection