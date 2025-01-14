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
        return response()->json(['success' => true, 'video_gallerys' => $video_gallerys]);
    }





    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|array|min:1',
            'title.*' => 'required|string|max:255',
            'video' => 'required|array|min:1',
            'video.*' => 'required|mimes:mp4,mov,avi,wmv,flv,mkv|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }





        if (count($request->input('title')) !== count($request->file('video'))) {
            return response()->json(['error' => 'عدد العناوين لا يتطابق مع عدد الفيديوهات.'], 400);
        }

        try {
            $imagePaths = [];
            $getID3 = new getID3();

            if ($request->hasFile('video')) {
                foreach ($request->file('video') as $index => $video) {
                    $videoPath = $video->store('video/video_gallery', 'public');
                    $fullPath = storage_path('app/public/' . $videoPath);

                    $fileInfo = $getID3->analyze($fullPath);
                    $duration = $fileInfo['playtime_seconds'] ?? 0;

                    $imagePaths[] = [
                        'path' => 'storage/video/video_gallery/' . $videoPath,
                        'duration' => round($duration),
                        'title' => $request->input('title')[$index],
                    ];
                }
            }

            foreach ($imagePaths as $videoData) {
                video_gallery::create([
                    'video' => $videoData['path'],
                    'duration' => $videoData['duration'],
                    'title' => $videoData['title'],
                ]);
            }

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $imagePaths], 201);
        } catch (\Exception $e) {
            Log::error('Error storing video: ' . $e->getMessage());
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }







    public function update(Request $request, $id)
    {
        $video_gallery = video_gallery::find($id);

        if (!$video_gallery) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'video' => 'required|array|min:1',
            'title.*' => 'required|string|max:255',
            'video.*' => 'required|mimes:mp4,mov,avi,wmv,flv,mkv|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            $getID3 = new getID3();
            if ($request->hasFile('video')) {
                if (file_exists(public_path('storage/' . $video_gallery->video))) {
                    unlink(public_path('storage/' . $video_gallery->video));
                }

                $videoPath = $request->file('video')[0]->store('video/video_gallery', 'public');
                $fullPath = storage_path('app/public/' . $videoPath);

                $fileInfo = $getID3->analyze($fullPath);
                $duration = $fileInfo['playtime_seconds'] ?? 0;

                $video_gallery->update([
                    'video' => $videoPath,
                    'title' => $input['title'],
                    'duration' => $duration,
                ]);
            }

            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $video_gallery]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }




    public function destroy($id)
    {
        $video_gallery = video_gallery::find($id);

        if (!$video_gallery) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $video_gallery->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
