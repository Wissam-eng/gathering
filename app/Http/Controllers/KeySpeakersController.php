<?php

namespace App\Http\Controllers;

use App\Models\Key_speakers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class KeySpeakersController extends Controller
{
    public function index()
    {

        $Key_speakerss = Key_speakers::all();
        return response()->json(['success' => true, 'Key_speakerss' => $Key_speakerss]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'nullable|mimes:pdf,xlsx,doc,docx,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            $imagePath = null;
            $filePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/Key_speakers', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
            }

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('files/Key_speakers', 'public');
                $filePath = 'storage/app/public/' . $filePath;
            }

            $Key_speakers = Key_speakers::create([
                'title' => $request->input('title'),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'image' => $imagePath,
                'file' => $filePath,
                'address' => $request->input('address'),
                'date' => $request->input('date'),
                'text' => $request->input('text'),
            ]);

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $Key_speakers], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $Key_speakers = Key_speakers::find($id);

        if (!$Key_speakers) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'nullable|mimes:pdf,xlsx,doc,docx,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            $input = $request->all();

            if ($request->hasFile('image')) {
                if ($Key_speakers->image && file_exists(public_path('storage/' . $Key_speakers->image))) {
                    unlink(public_path('storage/' . $Key_speakers->image));
                }
                $imagePath = $request->file('image')->store('images/Key_speakers', 'public');
                $input['image'] =  'storage/app/public/' . $imagePath;

            }

            if ($request->hasFile('file')) {
                if ($Key_speakers->file && file_exists(public_path('storage/' . $Key_speakers->file))) {
                    unlink(public_path('storage/' . $Key_speakers->file));
                }
                $filePath = $request->file('file')->store('files/Key_speakers', 'public');
                $input['file'] =  'storage/app/public/' . $filePath;
            }

            $Key_speakers->update($input);

            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $Key_speakers]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }



    public function destroy($id)
    {
        $Key_speakers = Key_speakers::find($id);

        if (!$Key_speakers) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $Key_speakers->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
