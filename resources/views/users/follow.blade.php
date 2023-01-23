<button class="btn btn-primary btn-xs waves-effect mb-2 waves-light follow-btn" data-user-id="{{ $users->id }}">
    <span> {{ auth()->user()->isFollowing($users)? 'Following': 'Follow' }}</span>

</button>

