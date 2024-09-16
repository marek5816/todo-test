<div class="card mb-4">
    <div class="card-header">{{ $title }}</div>
    <div class="card-body">
        <form action="{{ $actionUrl }}" method="GET" class="d-flex justify-content-around">
            @if($isTask)
                <div class="form-group">
                    <label for="completed">Task Status</label>
                    <select class="form-select" name="completed">
                        <option value=""></option>
                        <option value="1" {{ request('completed') == '1' ? 'selected' : '' }}>Done</option>
                        <option value="0" {{ request('completed') == '0' ? 'selected' : '' }}>Incompleted</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-select" name="category">
                        <option value=""></option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="shared">Ownership</label>
                    <select class="form-select" name="shared">
                        <option value=""></option>
                        <option value="0" {{ request('shared') == '0' ? 'selected' : '' }}>My Tasks</option>
                        <option value="1" {{ request('shared') == '1' ? 'selected' : '' }}>Shared with me</option>
                    </select>
                </div>
            @endif
            <div class="form-group">
                <label for="deleted">Deleted</label>
                <select class="form-select" name="deleted">
                    <option value=""></option>
                    <option value="1" {{ request('deleted') == '1' ? 'selected' : '' }}>Yes</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <button type="button" class="btn btn-secondary" onclick="resetFormFields(this)">Reset Filters</button>
        </form>
    </div>
</div>
