<div class="card">
    <div class="card-header">{{ $title }}</div>
    <ul class="list-group list-group-flush">
        @foreach($items as $item)
            <li class="list-group-item {{ $isTask && $item->completed_at ? 'done' : '' }}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">{{ $item->name }}</h5>
                        <p class="mb-1">{{ $item->description ?? '' }}</p>
                        @if($isTask)
                            <small>Categories:
                                @foreach($item->categories as $category)
                                    <span class="badge bg-primary">{{ $category->name }}</span>
                                @endforeach
                            </small>
                            <br>
                            @if($item->isSharedWithCurrentUser())
                                <small>Shared from:
                                    <span class="badge bg-info">{{ $item->creator->name }}</span>
                                </small>
                            @else
                                <small>Shared with:
                                    @foreach($item->shares as $share)
                                    <span class="badge bg-primary">{{ $share->name }}</span>
                                    @endforeach
                                </small>
                            @endif
                            <br>
                            <small>Created At: {{ \Carbon\Carbon::parse($item->created_at)->format("H:i d.m.Y") }}</small>
                            @if(isset($item->completed_by))
                                <br>
                                <small>Completed By: {{ $item->completer->name }}</small>
                            @endif
                        @else
                            <small>Number of tasks: {{ count($item->todoTasks) }}</small>
                        @endif
                    </div>
                    <div>
                        @if($isTask)
                            @if($item->deleted_at == null)
                                <a href="{{ route('todo.task.edit', $item->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                            @endif

                            @if(!$item->isSharedWithCurrentUser())
                                @if($item->trashed())
                                    <form action="{{ route('todo.task.restore', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                    </form>
                                @else
                                    <form action="{{ route('todo.task.delete', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')">Delete</button>
                                    </form>
                                @endif
                            @endif

                            @if(is_null($item->deleted_at))
                                @if($item->completed_at)
                                    <form action="{{ route('todo.task.incomplete', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-secondary">Mark as Incomplete</button>
                                    </form>
                                @else
                                    <form action="{{ route('todo.task.done', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">Mark as Done</button>
                                    </form>
                                @endif
                            @endif
                        @else
                            @if($item->deleted_at == null)
                                <a href="{{ route('todo.category.edit', $item->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                            @endif
                            @if($item->trashed())
                                <form action="{{ route('todo.category.restore', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                </form>
                            @else
                                <form action="{{ route('todo.category.delete', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?\n\nCategory will be removed from {{ count($item->todoTasks) }} ToDos')">Delete</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
