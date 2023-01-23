<?php

namespace App\Http\Controllers\Web;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LikeRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UnlikeRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Models\Like;

class PostController extends Controller
{


    public function store(StorePostRequest $request)
    {

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;

        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $PostImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $PostImage);
            $input['image'] = "$PostImage";
        }

        Post::create($input);

        return back()
            ->with('success', 'Post created successfully.');
    }


    public function like(Request $request)
    {


        $post = Post::find($request->id);

        $like = $post->likes()->where('user_id', auth()->id());

        if (!$like->count()) {
            $post->likes()->create([
                'user_id' => Auth::id(),
            ]);
            $status = 'liked this';

            return response()->json(['count' =>$post->likes()->where('likeable_id', $post->id)->count(),'status'=>$status]);
        }

        $like->delete();

        $status ='';

        return response()->json(['count' =>$post->likes->where('likeable_id', $post->id)->count(),'status'=>$status]);

    }

    public function delete($id)

    {
        if (Auth::user()->id) {
            $post=Post::find($id);
            $post->likes()->delete();
            $post->delete();
        }
        return back();
    }
}
