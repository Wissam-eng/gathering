<?php

namespace App\Http\Controllers;

use App\Models\Forum_management;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ForumManagementController extends Controller
{
    public function index()
    {

        $Forum_managements = Forum_management::all();
        return response()->json(['success' => true, 'Forum_managements' => $Forum_managements]);
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
                $imagePath = $request->file('image')->store('images/Forum_management', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
            }

            $Forum_management = Forum_management::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath ?? null,
                'address' => $request->input('address'),
                'date' => $request->input('date'),
                'text' => $request->input('text'),
            ]);

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $Forum_management], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {

        $Forum_management = Forum_management::find($id);

        if (!$Forum_management) {
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
                if ($Forum_management->image && file_exists(public_path('storage/' . $Forum_management->image))) {
                    unlink(public_path('storage/' . $Forum_management->image));
                }
                $imagePath = $request->file('image')->store('images/Forum_management', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $input['image'] = $imagePath;
            }
            $Forum_management->update($input);
            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $Forum_management]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $Forum_management = Forum_management::find($id);

        if (!$Forum_management) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $Forum_management->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
