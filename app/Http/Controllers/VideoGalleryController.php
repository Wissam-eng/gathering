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
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        if (
            count($request->input('title')) !== count($request->file('video')) ||
            count($request->file('video')) !== count($request->file('images'))
        ) {
            return response()->json(['error' => 'عدد العناوين، الفيديوهات والصور لا يتطابق.'], 400);
        }

        try {
            $data = [];
            $getID3 = new getID3();

            foreach ($request->file('video') as $index => $video) {
                // حفظ الفيديو
                $videoPath = $video->store('video/video_gallery', 'public');
                $fullVideoPath = storage_path('app/public/' . $videoPath);

                // حساب مدة الفيديو
                $fileInfo = $getID3->analyze($fullVideoPath);
                $duration = $fileInfo['playtime_seconds'] ?? 0;

                // حفظ الصورة
                $image = $request->file('images')[$index];
                $imagePath = $image->store('images/video_gallery', 'public');

                // تخزين البيانات
                $data[] = [
                    'video' => 'storage/video/video_gallery/' . $videoPath,
                    'images' => 'storage/images/video_gallery/' . $imagePath,
                    'duration' => round($duration),
                    'title' => $request->input('title')[$index],
                ];
            }

            // حفظ البيانات في قاعدة البيانات
            foreach ($data as $item) {
                video_gallery::create($item);
            }

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $data], 201);
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

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv,flv,mkv|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            $input = $request->all();

            // تحديث الصورة إذا تم رفع صورة جديدة
            if ($request->hasFile('images')) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($video_gallery->image && file_exists(public_path($video_gallery->image))) {
                    unlink(public_path($video_gallery->image));
                }

                // رفع الصورة الجديدة
                $imagePath = $request->file('images')->store('images/video_gallery', 'public');
                $input['image'] = 'storage/images/video_gallery/' . $imagePath;
            } else {
                $input['image'] = $video_gallery->image; // الاحتفاظ بالصورة القديمة إذا لم يتم رفع صورة جديدة
            }

            // تحديث الفيديو إذا تم رفع فيديو جديد
            if ($request->hasFile('video')) {
                // حذف الفيديو القديم إذا كان موجودًا
                if ($video_gallery->video && file_exists(public_path($video_gallery->video))) {
                    unlink(public_path($video_gallery->video));
                }

                // رفع الفيديو الجديد
                $videoPath = $request->file('video')->store('video/video_gallery', 'public');
                $fullPath = storage_path('app/public/' . $videoPath);

                // استخراج مدة الفيديو
                $getID3 = new getID3();
                $fileInfo = $getID3->analyze($fullPath);
                $input['duration'] = $fileInfo['playtime_seconds'] ?? 0;
                $input['video'] = 'storage/video/video_gallery/' . $videoPath;
            } else {
                $input['video'] = $video_gallery->video; // الاحتفاظ بالفيديو القديم إذا لم يتم رفع فيديو جديد
                $input['duration'] = $video_gallery->duration; // الاحتفاظ بالمدة القديمة
            }

            // تحديث البيانات في قاعدة البيانات
            $video_gallery->update([
                'title' => $input['title'],
                'image' => $input['image'],
                'video' => $input['video'],
                'duration' => $input['duration'],
            ]);

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
