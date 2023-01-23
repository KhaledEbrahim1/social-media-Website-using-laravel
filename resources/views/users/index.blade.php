@extends('layout')

@section('content')
    <div class="container mt-4 mb-5">

        <div class="d-flex justify-content-center row">

            <div class="col-xl-7">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <!-- comment box -->
                        @auth

                            <form action="{{ route('create-post') }}" method="post" enctype="multipart/form-data"
                                class="comment-area-box mb-3">
                                @csrf
                                <span class="input-icon">
                                    <textarea rows="1" name="title" class="form-control" placeholder="Post Title..."></textarea>
                                    @if ($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                    <textarea rows="3" name="description" class="form-control" placeholder="Write something..."></textarea>
                                </span>
                                <div class="comment-area-btn">
                                    <div class="float-end">
                                        <button type="submit"
                                            class="btn btn-sm btn-dark waves-effect waves-light">Post</button>
                                    </div>
                                    <div>

                                        <label for="customFile2"> <i class="fa fa-camera"></i></label>
                                        <input type="file" class="form-control d-none" id="customFile2" name="image"
                                            onchange="loadFile(event)" />


                                    </div>
                                </div>
                                <div>
                                    <img id="output" style="width: 20%;">
                                </div>

                            </form>
                            <hr>
                            <hr>

                        @endauth
                        <!-- end comment box -->

                        <!-- Story Box-->
                        @foreach ($posts as $post)
                            <!-- Story Box-->
                            <div class="border border-syan p-4 mb-2">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('profile.user', [$post->user->id, $post->user->name]) }}"><img
                                            class="me-2 avatar-sm rounded-circle"
                                            src="{{ asset('/storage/images/' . $post->user->image) }}" alt=""></a>
                                    <div class="w-100">
                                        <h5 class="m-0">{{ $post->user->name }}</h5>
                                        @auth
                                            @if (Auth::user()->id == $post->user->id)
                                                <form action="{{ route('delete.post', $post->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger float-end">Delete</button>
                                                </form>
                                            @endif
                                        @endauth

                                        <p class="text-muted"><small>{{ $post->created_at->diffForHumans() }}</small></p>

                                    </div>
                                </div>
                                <p>{{ $post->title }}</p>
                                <hr>
                                <div>
                                    {{ $post->description }}
                                </div>
                                @if ($post->image)
                                    <div class="feed-image p-4 px-2"><img class=" img-fluid img-responsive"
                                            src="/image/{{ $post->image }}"></div>
                                @endif
                                @include('users.like')
                            </div>
                        @endforeach

                        <div class="text-center">
                            <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-spin mdi-loading me-1"></i>
                                Load more </a>
                        </div>
                    </div>
                </div> <!-- end card-->

            </div> <!-- end col -->
        </div>
    </div>
@endsection
