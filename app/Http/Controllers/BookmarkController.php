<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Bookmark;
use Auth;
use SEO;

class BookmarkController extends Controller
{
	public function index() {
        SEO::setTitle('شب | علاقه مندی های من ');
        $user = Auth::user();
        $bookmarks = $user->bookmarks()->orderBy('id', 'desc')->paginate(20);
        return view('userpanel',['page' => 'bookmarks', 'bookmarks' => $bookmarks]);
    }

    public function store($id) {
        $user = Auth::user();
        $bookmark = Bookmark::where('user_id', $user->id)->where('house_id', $id)->first();
        
        if(empty($bookmark))
            Bookmark::create(array('user_id' => $user->id, 'house_id' => $id));
        else
            return response()->json(['status' => 'failed', 'error' => 'قبلا ثبت شده است.']);
  
        return response()->json(['status' => 'success']);
    }

	public function destroy($id) {
        $user = Auth::user();
        $bookmark = Bookmark::where('user_id', $user->id)->where('house_id', $id)->first();

        if(empty($bookmark))
            return response()->json(['status' => 'failed', 'error' => 'پیدا نشد.'], 404);
        else
        	Bookmark::destroy($bookmark->id);

        return response()->json(['status' => 'success']);
    }
}
