<?php

namespace App\Http\Controllers;

use App\Models\Media_partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class MediaPartnerController extends Controller
{
    public function index()
    {

        $Media_partners = Media_partner::all();
        return response()->json(['success' => true, 'Media_partners' => $Media_partners]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/Media_partner', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
            }

            $Media_partner = Media_partner::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath ?? null,
                'address' => $request->input('address'),
                'date' => $request->input('date'),
                'text' => $request->input('text'),
            ]);

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $Media_partner], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {

        $Media_partner = Media_partner::find($id);

        if (!$Media_partner) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            if ($request->hasFile('image')) {
                if ($Media_partner->image && file_exists(public_path('storage/' . $Media_partner->image))) {
                    unlink(public_path('storage/' . $Media_partner->image));
                }
                $imagePath = $request->file('image')->store('images/Media_partner', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $input['image'] = $imagePath;
            }
            $Media_partner->update($input);
            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $Media_partner]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $Media_partner = Media_partner::find($id);

        if (!$Media_partner) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $Media_partner->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
