<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use App\Models\supervisor_speech;
use Illuminate\Http\Request;

class SupervisorSpeechController extends Controller
{
    public function index()
    {

        $supervisor_speechs = supervisor_speech::all();
        return response()->json(['success' => true, 'supervisor_speechs' => $supervisor_speechs]);
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
                $imagePath = $request->file('image')->store('images/supervisor_speech', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
            }

            $supervisor_speech = supervisor_speech::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath ?? null,
                'address' => $request->input('address'),
                'date' => $request->input('date'),
                'text' => $request->input('text'),
            ]);

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $supervisor_speech], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {

        $supervisor_speech = supervisor_speech::find($id);

        if (!$supervisor_speech) {
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
                if ($supervisor_speech->image && file_exists(public_path('storage/' . $supervisor_speech->image))) {
                    unlink(public_path('storage/' . $supervisor_speech->image));
                }
                $imagePath = $request->file('image')->store('images/supervisor_speech', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $input['image'] = $imagePath;
            }
            $supervisor_speech->update($input);
            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $supervisor_speech]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $supervisor_speech = supervisor_speech::find($id);

        if (!$supervisor_speech) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $supervisor_speech->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
