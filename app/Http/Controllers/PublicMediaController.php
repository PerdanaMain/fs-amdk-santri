<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class PublicMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medias = Media::orderBy('created_at', 'desc')->paginate(10);
        return view('pages.media.index', compact('medias'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $media = Media::findOrFail($id);
        $recentMedias = Media::where('media_id', '!=', $id)->orderBy('created_at', 'desc')->take(5)->get();
        return view('pages.media.detail', compact('media', 'recentMedias'));
    }
}
