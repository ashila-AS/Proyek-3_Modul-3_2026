<label for="code">Kode</label>
<input
    id="code"
    name="code"
    value="{{ old('code', $activity->code ?? '') }}"
>
@error('code')
    <p style="color:red;">{{ $message }}</p>
@enderror

<br><br>

<label for="title">Judul</label>
<input
    id="title"
    name="title"
    value="{{ old('title', $activity->title ?? '') }}"
>
@error('title')
    <p style="color:red;">{{ $message }}</p>
@enderror

<br><br>

<label for="description">Deskripsi</label>
<textarea id="description" name="description">{{ old('description', $activity->description ?? '') }}</textarea>
@error('description')
    <p style="color:red;">{{ $message }}</p>
@enderror

<br><br>

<label for="activity_date">Tanggal</label>
<input
    type="date"
    id="activity_date"
    name="activity_date"
    value="{{ old('activity_date', isset($activity) ? $activity->activity_date->format('Y-m-d') : '') }}"
>
@error('activity_date')
    <p style="color:red;">{{ $message }}</p>
@enderror

<br><br>

<label for="location">Lokasi</label>
<input
    id="location"
    name="location"
    value="{{ old('location', $activity->location ?? '') }}"
>
@error('location')
    <p style="color:red;">{{ $message }}</p>
@enderror

<br><br>

<label for="capacity">Kapasitas</label>
<input
    type="number"
    id="capacity"
    name="capacity"
    value="{{ old('capacity', $activity->capacity ?? '') }}"
>
@error('capacity')
    <p style="color:red;">{{ $message }}</p>
@enderror

<br><br>

<label for="category_id">Kategori</label>
<select name="category_id" id="category_id">
    <option value="">-- Pilih Kategori --</option>

    @foreach ($categories as $category)
        <option
            value="{{ $category->id }}"
            @selected(old('category_id', $activity->category_id ?? '') == $category->id)
        >
            {{ $category->name }}
        </option>
    @endforeach
</select>
@error('category_id')
    <p style="color:red;">{{ $message }}</p>
@enderror

<br><br>
