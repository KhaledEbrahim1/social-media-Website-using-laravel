@extends('layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-5">
                <div class="card">

                    @if ($message = Session::get('message'))
                        <div class="alert alert-success alert-block">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <label for="profile_picture">
                                    <img src="{{ asset('/storage/images/' . $users->image) }}"
                                        class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                </label>

                                <div class="w-100 ms-3">
                                    <h4 class="my-0">{{ $users->name }}</h4>
                                    <p class="text-muted">@webdesigner</p>
                                    @auth
                                    @if (auth()->user()->id !== $users->id)
                                        @include('users.follow')

                                        <a href="{{ url('Text-Me',$users->id) }}" target="_blank" rel="noopener noreferrer"><button type="button"  class="btn btn-success btn-xs waves-effect mb-2 waves-light">Message</button></a>
                                        <br>
                                    @endif

                                    <span class="mb-2 mr-2 font-weight-bold shadow">{{ $users->followers(auth()->user())->count() }}
                                        followers</span>
                                    <span>|</span>
                                    <span class="mb-2 mr-2 font-weight-bold shadow">{{ $users->following(auth()->user())->count() }}
                                        following</span>
                                @endauth
                                </div>

                            </div>

                            <div class="mt-3">

                                <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ms-2">{{ $users->name }}
                                           </span></p>


                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2">{{ $users->email }}</span></p>

                            </div>


                        </div>
                </div> <!-- end card -->
                @auth

                    @if (Auth::user()->id == $users->id)
                       <a href="{{ route('profile.edit',$users->id) }}"><button type="submit " class="btn btn-primary">Edit</button></a>
                    @endif
                @endauth
                </form>



            </div> <!-- end col-->

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
                            @if (Auth::user()->id == $users->id)

                                <form action="{{ route('create-post') }}" method="post" enctype="multipart/form-data"
                                    class="comment-area-box mb-3">
                                    @csrf
                                    <span class="input-icon">
                                        <textarea rows="1" name="title" class="form-control" placeholder="Post Title..."></textarea>
                                        <textarea rows="3" name="description" class="form-control" placeholder="Write something..."></textarea>
                                    </span>
                                    <div class="comment-area-btn">
                                        <div class="float-end">
                                            <button type="submit"
                                                class="btn btn-sm btn-dark waves-effect waves-light">Post</button>
                                        </div>
                                        <div>

                                            <label for="customFile2"> <i class="fa fa-camera"></i></label>
                                            <input type="file" class="form-control d-none" id="customFile2" name="image" />


                                        </div>
                                    </div>
                                </form>
                            @endauth

                        @endauth
                        <!-- end comment box -->

                        <!-- Story Box-->
                        @foreach ($posts as $post)
                            <!-- Story Box-->
                            <div class="border border-light p-2 mb-3">
                                <div class="d-flex align-items-start">
                                    <img class="me-2 avatar-sm rounded-circle"
                                        src="{{ asset('/storage/images/' . $users->image) }}"alt="">
                                    <div class="w-100">
                                        <h5 class="m-0">{{ $users->name }}</h5>
                                        @auth
                                            @if (Auth::user()->id == $users->id)
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
                                <div>


                                    {{ $post->description }}

                                </div>
                                @if ($post->image)
                                    <div class="feed-image p-2 px-3"><img class=" img-fluid img-responsive"
                                            src="/image/{{ $post->image }}"></div>
                                @endif

                                @include('users.like')
                            </div>
                        @endforeach

                        <div class="text-center">
                            <a href="javascript:void(0);" class="text-danger"><i
                                    class="mdi mdi-spin mdi-loading me-1"></i>
                                Load more </a>
                        </div>
                </div>
            </div> <!-- end card-->

        </div> <!-- end col -->
    </div>
    <!-- end row-->

</div>
@endsection
