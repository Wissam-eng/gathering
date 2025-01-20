<?php

namespace App\Http\Controllers;

use App\Models\video_gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use getID3;

class VideoGalleryController extends Controller
{
    public function index()
    {
        $video_gallerys = video_gallery::all();
        return view('video_gallery.index', compact('video_gallerys'));
    }


    public function create()
    {
        return view('video_gallery.create');
    }



    public function edit($id)
    {

        $card = video_gallery::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('video_gallery.edite')->with('card', $card);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|array|min:1',
            'title.*' => 'required|string|max:255',
            'video' => 'required|array|min:1',
            'video.*' => 'required|mimes:mp4,mov,avi,wmv,flv,mkv|max:10000',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,svg,webp,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation failed');
        }

        if (
            count($request->input('title')) !== count($request->file('video')) ||
            count($request->file('video')) !== count($request->file('images'))
        ) {
            return redirect()->back()->with('error', 'The number of titles, videos, and images do not match');
        }

        try {
            $data = [];
            $getID3 = new getID3();

            foreach ($request->file('video') as $index => $video) {
                $videoPath = $video->store('images/video_gallery/video', 'public');
                $fullVideoPath =  $videoPath;

                $fileInfo = $getID3->analyze($fullVideoPath);
                $duration = $fileInfo['playtime_seconds'] ?? 0;

                $image = $request->file('images')[$index];
                $imagePath = $image->store('images/video_gallery/imgs', 'public');


                $data[] = [
                    'video' => 'storage/app/public/'  . $videoPath,
                    'images' => 'storage/app/public/'  . $imagePath,
                    'duration' => round($duration),
                    'title' => $request->input('title')[$index],
                ];
            }



            foreach ($data as $item) {
                video_gallery::create($item);
            }

            return redirect()->route('video_gallery.index')->with('success', 'Data added successfully');
        } catch (\Exception $e) {
            Log::error('Error storing video: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $video_gallery = video_gallery::find($id);

        if (!$video_gallery) {
            return redirect()->route('video_gallery.index')->with('error', 'Data not found');
        }

        $validator = Validator::make($request->all(), [

            'title' => 'sometimes|string|max:255',

            'video' => 'sometimes|mimes:mp4,mov,avi,wmv,flv,mkv|max:10000',

            'images' => 'image|mimes:jpeg,svg,webp,png,jpg,gif|max:2048',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation failed');
        }

        try {
            $input = $request->all();

            if ($request->hasFile('images')) {
                if ($video_gallery->image && file_exists(public_path($video_gallery->image))) {
                    unlink(public_path($video_gallery->image));
                }

                $imagePath = $request->file('images')->store('images/video_gallery', 'public');
                $input['image'] = 'storage/images/video_gallery/' . $imagePath;
            } else {
                $input['image'] = $video_gallery->image;
            }

            if ($request->hasFile('video')) {
                if ($video_gallery->video && file_exists(public_path($video_gallery->video))) {
                    unlink(public_path($video_gallery->video));
                }

                $videoPath = $request->file('video')->store('video/video_gallery', 'public');
                $fullPath = storage_path('app/public/' . $videoPath);

                $getID3 = new getID3();
                $fileInfo = $getID3->analyze($fullPath);
                $input['duration'] = $fileInfo['playtime_seconds'] ?? 0;
                $input['video'] = 'storage/video/video_gallery/' . $videoPath;
            } else {
                $input['video'] = $video_gallery->video;
                $input['duration'] = $video_gallery->duration;
            }

            $video_gallery->update($input);

            return redirect()->route('video_gallery.index')->with('success', 'Data updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $video_gallery = video_gallery::find($id);

        if (!$video_gallery) {
            return redirect()->route('video_gallery.index')->with('error', 'Data not found');
        }

        try {
            $video_gallery->delete();
            return redirect()->route('video_gallery.index')->with('success', 'Data deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
