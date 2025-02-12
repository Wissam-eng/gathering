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
        $validator = Validator::make($request->all(), [
            'external_link' => 'required|string',
            'title' => 'required|string|max:255',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv,flv,mkv|max:10000',
            'images' => 'nullable|image|mimes:jpeg,png,svg,webp,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation failed');
        }

        try {

            // $getID3 = new getID3();

            // // تخزين الفيديو
            // $videoPath = $request->file('video')->store('video_gallery/video', 'public');

            // $fullVideoPath = 'storage/app/public/' . $videoPath;
            // // $fullVideoPath = storage_path('app/public/' . $videoPath);

            // // الحصول على مدة الفيديو
            // $fileInfo = $getID3->analyze($fullVideoPath);
            // $duration = $fileInfo['playtime_seconds'] ?? 0;

            // // تخزين الصورة
            // $imagePath = $request->file('images')->store('video_gallery/imgs', 'public');

            // $imagePath = 'storage/app/public/' . $imagePath;



            // إنشاء العنصر وحفظه
            video_gallery::create([
                'external_link' => $request->input('external_link'),
                'title' => $request->input('title'),
                // 'video' => $fullVideoPath,
                // 'images' => $imagePath,
                // 'duration' => round($duration),
            ]);

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
            'external_link' => 'required|string',

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
