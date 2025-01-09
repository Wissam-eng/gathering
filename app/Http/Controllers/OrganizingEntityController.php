<?php

namespace App\Http\Controllers;

use App\Models\organizing_entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class OrganizingEntityController extends Controller
{
    public function index()
    {

        $organizing_entitys = organizing_entity::all();
        return response()->json(['success' => true, 'organizing_entitys' => $organizing_entitys]);
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
                $imagePath = $request->file('image')->store('images/organizing_entity', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
            }

            $organizing_entity = organizing_entity::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath ?? null,
                'address' => $request->input('address'),
                'date' => $request->input('date'),
                'text' => $request->input('text'),
            ]);

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $organizing_entity], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {

        $organizing_entity = organizing_entity::find($id);

        if (!$organizing_entity) {
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
                if ($organizing_entity->image && file_exists(public_path('storage/' . $organizing_entity->image))) {
                    unlink(public_path('storage/' . $organizing_entity->image));
                }
                $imagePath = $request->file('image')->store('images/organizing_entity', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $input['image'] = $imagePath;
            }
            $organizing_entity->update($input);
            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $organizing_entity]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $organizing_entity = organizing_entity::find($id);

        if (!$organizing_entity) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $organizing_entity->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
