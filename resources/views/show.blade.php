<h1>{{ $record->name }}</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $record->email }}</h5>
        <p class="card-text">{{ $record->phone }}</p>
        <p class="card-text">{{ $record->address }}</p>
    </div>
</div>

<a href="/records/{{ $record->id }}/edit" class="btn btn-warning mt-3">Edit</a>
<form action="/records/{{ $record->id }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger mt-3">Delete</button>
</form>
<a href="/" class="btn btn-secondary mt-3">Back to Records</a>
