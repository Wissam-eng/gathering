<?php

namespace App\Http\Controllers;

use App\Models\Photo_gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class PhotoGalleryController extends Controller
{
    // public function index()
    // {

    //     $Photo_gallerys = Photo_gallery::all();
    //     return response()->json(['success' => true, 'Photo_gallerys' => $Photo_gallerys]);
    // }


    public function index()
    {
        try {
            $photoGalleries = Photo_gallery::all()
                ->groupBy('code')
                ->map(function ($group) {
                    $cover = $group->first()->cover;

                    $images = $group->pluck('image');

                    return [
                        'cover' => $cover,
                        'images' => $images,
                    ];
                });

            return response()->json([
                'success' => true,
                'Photo_gallerys' => $photoGalleries,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }





    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            $code = Str::random(10);

            $imagePaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images/Photo_gallery/cover' . $code, 'public');
                    $imagePaths[] = 'storage/app/public/' . $imagePath;
                }
            }

            if ($request->hasFile('cover')) {
                $cover = $request->file('cover');
                $coverPath = $cover->store('images/Photo_gallery/cover' . $code, 'public');
                $coverPath = 'storage/app/public/' . $coverPath;
            } else {
                return response()->json(['error' => 'الكوفير مطلوب'], 400);
            }

            foreach ($imagePaths as $imagePath) {
                Photo_gallery::create([
                    'image' => $imagePath,
                    'cover' => $coverPath,
                    'code' => $code,
                ]);
            }

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => compact('code', 'imagePaths', 'coverPath')], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }








    public function update(Request $request, $code)
    {
        $photoGalleries = Photo_gallery::where('code', $code)->get();

        if ($photoGalleries->isEmpty()) {
            return response()->json(['error' => 'لا توجد بيانات لهذا الكود'], 404);
        }

        $validator = Validator::make($request->all(), [
            'images' => 'array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            if ($request->hasFile('cover')) {
                $currentCover = $photoGalleries->first()->cover;
                if (file_exists(public_path($currentCover))) {
                    unlink(public_path($currentCover));
                }

                $coverPath = $request->file('cover')->store('images/Photo_gallery/cover', 'public');
                $coverPath = 'storage/app/public/' . $coverPath;

                foreach ($photoGalleries as $gallery) {
                    $gallery->cover = $coverPath;
                    $gallery->save();
                }
            }

            if ($request->hasFile('images')) {
                foreach ($photoGalleries as $gallery) {
                    if (file_exists(public_path($gallery->image))) {
                        unlink(public_path($gallery->image));
                    }
                    $gallery->delete();
                }

                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images/Photo_gallery', 'public');
                    $imagePath = 'storage/app/public/' . $imagePath;

                    $Photo_gallery  = Photo_gallery::create([
                        'cover' => isset($coverPath) ? $coverPath : $photoGalleries->first()->cover,
                        'image' => $imagePath,
                        'code' => $code,
                    ]);
                }
            }

            return response()->json(['success' => 'تم تعديل البيانات بنجاح' ,
            'Photo_gallery' => $Photo_gallery], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }




    public function destroy($id)
    {
        $Photo_gallery = Photo_gallery::find($id);

        if (!$Photo_gallery) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $Photo_gallery->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
