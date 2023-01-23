<button class="fa  fa-heart like-btn text-danger" id="like" data-id="{{ $post->id }}" style="border:none;">
    <span class="count-{{ $post->id }}">{{ $post->likes_count }} </span> <i
        class="liked-{{ $post->id }} text-danger">
        @if ($post->likes_count1)
            liked this
        @endif
    </i></button>

@section('scripts')
    <script>
        $('.like-btn').on('click', function(e) {

            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                type: "POST",
                url: '/like',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                    $('.count-' + id).html(response.count);
                    $('.liked-' + id).html(response.status);
                }
            });

        });
    </script>

    <script>
        $(document).on('click', '.follow-btn', function() {

            var button = $(this);
            var userId = button.data('user-id');

            $.ajax({
                url: '/follow/' + userId,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'following') {
                        button.text('Following');
                        button.addClass('following');
                    } else {
                        button.text('Follow');
                        button.removeClass('following');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    </script>
    <script>
        var loadFile = function(event){


            var output =document.getElementById('output');
            output.src =URL.createObjectURL(event.target.files[0]);

        };
    </script>
    <script>
        $(document).ready(function(){$(".img-fluid").click(function(){this.requestFullscreen()})});
    </script>
@endsection
