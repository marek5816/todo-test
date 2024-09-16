<div class="card mb-4">
    <div class="card-header">{{ $title }}</div>
    <div class="card-body">
        <form method="POST" action="{{ $actionUrl }}">
            @csrf
            @if(isset($task))
                @method('PATCH')
            @endif
            <div class="mb-3">
                <label for="taskName" class="form-label">Task Name</label>
                <input type="text" class="form-control" id="taskName" name="name" value="{{ old('name', $task->name ?? '') }}" required autofocus>
                @error('name')
                <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="taskDescription" class="form-label">Description</label>
                <textarea class="form-control" id="taskDescription" name="description" rows="3">{{ old('description', $task->description ?? '') }}</textarea>
                @error('description')
                <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="taskCategory" class="form-label">Category</label>
                <select class="form-select" id="taskCategory" name="categories[]" multiple>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if(isset($task) && $task->categories->contains($category->id)) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            @if(!isset($task) || (isset($task) && !$task->isSharedWithCurrentUser()))
                <div class="mb-3">
                    <label for="taskShare" class="form-label">Share</label>
                    <select class="form-select" id="taskShare" name="shares[]" multiple>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if(isset($task) && $task->shares->contains($user->id)) selected @endif>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <button type="submit" class="btn btn-success">{{ $buttonText }}</button>
        </form>
    </div>
</div>
