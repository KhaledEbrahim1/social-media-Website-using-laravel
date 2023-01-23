<?php

namespace App\Http\Controllers\Web;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\RegisterUserRequest;
use Error;
use GuzzleHttp\Psr7\Request as Psr7Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('user')->withLikes()->withCount('likes')
            ->latest()->get();

        return view('users.index', compact('posts'));
    }



    public function login()
    {

        if (Auth::check()) {
            return back();
        }

        return view('users.login');
    }
    public function StoreLogin(LoginUserRequest $request)
    {


        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')
                ->with('message', 'Signed in!');
        }
        return redirect()->back()->with('message', 'Login details are not valid!');
    }

    public function create()
    {

        if (Auth::check()) {
            return back();
        }

        return view('users.create');
    }

    public function store(RegisterUserRequest $request)
    {
        User::create([
            'name' => str_replace(' ', '', $request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password)

        ]);

        return redirect()->route('login');
    }


    public function show($id, $name)
    {
        $users = User::find($id);
        $posts = $users->posts()->withCount('likes')->withLikes()->latest()->get();

        return view('users.profile', compact('users', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function follow($id)
    {
        $users = User::find($id);

        if (auth()->user()->isFollowing($users)) {

            $users->revokeFollower(auth()->user());
        } else {
            auth()->user()->follow($users);
        }


        return response()->json([
            'status' => auth()->user()->isFollowing($users) ? 'following' : 'not_following'
        ]);
        // $user->following()->count(); // 1
        // $zuck->followers()->count(); // 1
    }


    public function profile_edit(Request $request)
    {
        if($request->id == auth()->user()->id){
            $users = User::find($request->id);

            return view('users.profile_edit', compact('users'));

        }
        return back();


    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'max:255',
            'email' => 'email|unique:users,email,' . auth()->id(),
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'storage/images/';
            $ProfileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $ProfileImage);
            $input['image'] = "$ProfileImage";
        }


        $user = auth()->user();
        $user->update($input);

        return back()->with('message', 'Profie update successfully');
    }


    public function search(Request $request)

    {
        $request->validate([
            'query' => 'required'
        ]);

        if ($query = !$request->input('query')) {
            abort(404);
        } else {
            $query = $request->input('query');
            $users = User::where('name', 'like', "%{$query}%")
                ->get();
            return view('users.search', compact('users'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('Home');
    }
}
