<div class="card mb-4">
    <div class="card-header">{{ $title }}</div>
    <div class="card-body">
        <form method="POST" action="{{ $actionUrl }}">
            @csrf
            @if(isset($category))
                @method('PATCH')
            @endif
            <div class="mb-3">
                <label for="categoryName" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="categoryName" name="name" value="{{ old('name', $category->name ?? '') }}" required autofocus>
                @error('name')
                <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">{{ $buttonText }}</button>
        </form>
    </div>
</div>
