@extends('layout')

@section('content')
    <center>
        <div class="row">
            <div class="col-md-12">
                <hr>
                @foreach ($users as $user)
                    <h2>Results:</h2>
                    <div class="card" style="width: 13rem;">
                        <img src="{{ asset('/storage/images/' . $user->image) }}" class="card-img-top" alt="avatar">
                        <div class="card-body">
                            <h5 class="card-title">{{ $user->name }}</h5>

                            <a href="{{ route('profile.user', [$user->id, $user->name]) }}" class="btn btn-primary">Visit</a>
                        </div>
                    </div>
                @endforeach
    </center>
@endsection
