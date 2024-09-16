@extends('base')

@section('content')
    <div class="container mt-5">
        <!-- Tasks List -->
        <div class="card">
            <div class="card-header">Notification List</div>
            <ul class="list-group list-group-flush">
                @foreach($notifications as $notification)
                    <li class="list-group-item {{ is_null($notification->read_at) ? '' : 'done' }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">{{ $notification->data['message'] }}</h5>
                                <small>Created At: {{ \Carbon\Carbon::parse($notification->created_at)->format("H:i d.m.Y") }}</small>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation example" class="mt-4">
            <ul class="pagination">
                @if ($notifications->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $notifications->previousPageUrl() }}">Previous</a></li>
                @endif

                @for ($i = 1; $i <= $notifications->lastPage(); $i++)
                    <li class="page-item {{ $notifications->currentPage() == $i ? 'active disabled' : '' }}">
                        <a class="page-link" href="{{ $notifications->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                @if ($notifications->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $notifications->nextPageUrl() }}">Next</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </nav>
    </div>
@endsection
