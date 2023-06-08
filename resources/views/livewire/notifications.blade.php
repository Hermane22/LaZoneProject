<div>
    @foreach ($notifications as $notification)
        <div class="alert alert-{{ $notification->read_at ? 'secondary' : 'primary' }}">
            <h5>{{ $notification->data['title'] }}</h5>
            <p>{{ $notification->data['message'] }}</p>
            <small>{{ $notification->created_at->diffForHumans() }}</small>
        </div>
    @endforeach
</div>
