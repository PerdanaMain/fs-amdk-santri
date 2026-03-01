<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = session()->get('user');
        if (in_array($user->role_id, [3, 4])) {
            return redirect()->route('dashboard');
        }

        $medias = Media::orderBy('media_id', 'desc')->get();
        return view('pages.dashboard.media', compact('medias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'media_title' => 'required',
                'media_content' => 'required',
                'media_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $data = [
                'media_title' => $request->media_title,
                'media_content' => $request->media_content,
                'media_category' => $request->media_category,
            ];

            if ($request->hasFile('media_image')) {
                $file = $request->file('media_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('storage/media', $filename);
                $data['media_image'] = $filename;
            }

            Media::create($data);

            return redirect()->route('media.index')->with('media.success', 'Media berhasil ditambahkan');
        } catch (\Throwable $th) {
            return back()->with('media.error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'media_title' => 'required',
                'media_content' => 'required',
                'media_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $media = Media::findOrFail($id);

            $data = [
                'media_title' => $request->media_title,
                'media_content' => $request->media_content,
                'media_category' => $request->media_category,
            ];

            if ($request->hasFile('media_image')) {
                if ($media->media_image && file_exists(public_path('storage/media/' . $media->media_image))) {
                    unlink(public_path('storage/media/' . $media->media_image));
                }
                $file = $request->file('media_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('storage/media', $filename);
                $data['media_image'] = $filename;
            }

            $media->update($data);

            return redirect()->route('media.index')->with('media.success', 'Media berhasil diupdate');
        } catch (\Throwable $th) {
            return back()->with('media.error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $media = Media::findOrFail($id);
            if ($media->media_image && file_exists(public_path('storage/media/' . $media->media_image))) {
                unlink(public_path('storage/media/' . $media->media_image));
            }
            $media->delete();

            return response()->json([
                'status' => true,
                'message' => 'Media berhasil dihapus',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
