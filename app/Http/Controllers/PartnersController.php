<?php

namespace App\Http\Controllers;

use App\Models\partners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PartnersController extends Controller
{
    public function index()
    {

        $partnerss = partners::all();
        return response()->json(['success' => true, 'partnerss' => $partnerss]);
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
                    $imagePath = $image->store('images/partners', 'public');
                    $imagePaths[] = 'storage/app/public/' . $imagePath;
                }
            }

            foreach ($imagePaths as $imagePath) {
                $gallery =  partners::create([
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
        $partners = partners::find($id);

        if (!$partners) {
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
                foreach ($partners->get() as $item) {
                    if (file_exists(public_path('storage/' . $item->image))) {
                        unlink(public_path('storage/' . $item->image));
                    }
                }

                $imagePaths = [];

                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images/partners', 'public');
                    $imagePaths[] = 'storage/app/public/' . $imagePath;
                }

                foreach ($imagePaths as $imagePath) {
                    $partners->update([
                        'image' => $imagePath,
                    ]);
                }
            }

            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $partners]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }



    public function destroy($id)
    {
        $partners = partners::find($id);

        if (!$partners) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $partners->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
