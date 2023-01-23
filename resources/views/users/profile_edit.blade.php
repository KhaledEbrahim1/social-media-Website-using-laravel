@extends('layout')

@section('content')
    <div class="row">
        <div class="col-xl-5">
            <div class="card">

                @if ($message = Session::get('message'))
                    <div class="alert alert-success alert-block">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <label for="profile_picture">
                                <img src="{{ asset('/storage/images/' . $users->image) }}"
                                    class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                            </label>
                            <input type="file" id="profile_picture" name="image" onchange="loadFile(event)"
                                value="{{ asset('/storage/images/' . $users->image) }}" style="display: none;"><br><br>
                                <div>
                                    <img id="output"  class="rounded-circle avatar-lg img-thumbnail" style="width: 30%;">
                                </div>

                            <div class="w-100 ms-3">
                                <h4 class="my-0">{{ $users->name }}</h4>
                                <p class="text-muted">@webdesigner</p>
                            </div>
                        </div>

                        <div class="mt-3">

                            <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ms-2"><input
                                        type="text" name="name" value="{{ $users->name }}"
                                        style="border: none"></span></p>


                            <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2"><input
                                        type="text" name="email" value="{{ $users->email }}"
                                        style="border: none"></span></p>

                        </div>


                    </div>
                    <button type="submit " class="btn btn-success">Update</button>
                </form>
            </div> <!-- end card -->
        </div>
    </div>
@endsection

@section('scripts')
<script>
    var loadFile = function(event){


        var output =document.getElementById('output');
        output.src =URL.createObjectURL(event.target.files[0]);

    };
</script>
@endsection
