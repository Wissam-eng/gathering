<?php

namespace App\Http\Controllers;

use App\Models\video_gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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
            'video' => 'required|array|min:1',
            'video.*' => 'required|mimes:mp4,mov,avi,wmv,flv,mkv|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            $imagePaths = [];

            if ($request->hasFile('video')) {
                foreach ($request->file('video') as $image) {
                    $imagePath = $image->store('video/video_gallery', 'public');
                    $imagePaths[] = 'storage/app/public/' . $imagePath;
                }
            }

            foreach ($imagePaths as $imagePath) {
                $gallery =  video_gallery::create([
                    'video' => $imagePath,
                ]);
            }

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $imagePaths], 201);
        } catch (\Exception $e) {
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
            'video.*' => 'required|mimes:mp4,mov,avi,wmv,flv,mkv|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {

            if ($request->hasFile('video')) {
                foreach ($video_gallery->get() as $item) {

                    if (file_exists(public_path('storage/' . $item->video))) {
                        unlink(public_path('storage/' . $item->video));
                    }
                }

                $imagePaths = [];

                foreach ($request->file('video') as $video) {
                    $imagePath = $video->store('video/video_gallery', 'public');
                    $imagePaths[] = 'storage/app/public/' . $imagePath;
                }

                foreach ($imagePaths as $imagePath) {
                    $video_gallery->update([
                        'video' => $imagePath,
                    ]);
                }
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
