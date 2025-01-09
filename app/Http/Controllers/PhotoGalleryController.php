<?php

namespace App\Http\Controllers;

use App\Models\Photo_gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PhotoGalleryController extends Controller
{
    public function index()
    {

        $Photo_gallerys = Photo_gallery::all();
        return response()->json(['success' => true, 'Photo_gallerys' => $Photo_gallerys]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            $imagePaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images/Photo_gallery', 'public');
                    $imagePaths[] = 'storage/app/public/' . $imagePath;
                }
            }

            foreach ($imagePaths as $imagePath) {
               $gallery =  Photo_gallery::create([
                    'image' => $imagePath,
                ]);
            }

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $imagePaths], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }



    public function update(Request $request, $id)
    {
        $Photo_gallery = Photo_gallery::find($id);

        if (!$Photo_gallery) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'images' => 'array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            if ($request->hasFile('images')) {
                foreach ($Photo_gallery->get() as $item) {
                    if (file_exists(public_path('storage/' . $item->image))) {
                        unlink(public_path('storage/' . $item->image));
                    }
                }

                $imagePaths = [];

                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images/Photo_gallery', 'public');
                    $imagePaths[] = 'storage/app/public/' . $imagePath;
                }

                foreach ($imagePaths as $imagePath) {
                    $Photo_gallery->update([
                        'image' => $imagePath,
                    ]);
                }
            }

            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $Photo_gallery]);
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
