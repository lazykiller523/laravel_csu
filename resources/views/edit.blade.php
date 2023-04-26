<h1>Edit Record</h1>

<form action="/records/{{ $record->id }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $record->name }}" required autofocus>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $record->email }}" required>
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="tel" name="phone" id="phone" class="form-control" value="{{ $record->phone }}">
    </div>

    <div class="form-group">
        <label for="address">Address</label>
        <textarea name="address" id="address" rows="3" class="form-control">{{ $record->address }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
