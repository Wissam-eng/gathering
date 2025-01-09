<?php

namespace App\Http\Controllers;

use App\Models\goals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class GoalsController extends Controller
{
    public function index()
    {

        $goalss = goals::all();
        return response()->json(['success' => true, 'goalss' => $goalss]);
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
                $imagePath = $request->file('image')->store('images/goals', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
            }

            $goals = goals::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath ?? null,
                'address' => $request->input('address'),
                'date' => $request->input('date'),
                'text' => $request->input('text'),
            ]);

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $goals], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {

        $goals = goals::find($id);

        if (!$goals) {
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
                if ($goals->image && file_exists(public_path('storage/' . $goals->image))) {
                    unlink(public_path('storage/' . $goals->image));
                }
                $imagePath = $request->file('image')->store('images/goals', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $input['image'] = $imagePath;
            }
            $goals->update($input);
            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $goals]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $goals = goals::find($id);

        if (!$goals) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $goals->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
