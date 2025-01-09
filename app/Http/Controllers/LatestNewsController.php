<?php

namespace App\Http\Controllers;

use App\Models\Latest_news;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class LatestNewsController extends Controller
{
    public function index()
    {

        $Latest_newss = Latest_news::all();
        return response()->json(['success' => true, 'Latest_newss' => $Latest_newss]);
    }


    public function store(Request $request)
    {


        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/Latest_news', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
            }

            $Latest_news = Latest_news::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath ?? null,
                'date' => $request->input('date'),

            ]);

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $Latest_news], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {

        $Latest_news = Latest_news::find($id);

        if (!$Latest_news) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date_format:Y-m-d',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            if ($request->hasFile('image')) {
                if ($Latest_news->image && file_exists(public_path('storage/' . $Latest_news->image))) {
                    unlink(public_path('storage/' . $Latest_news->image));
                }
                $imagePath = $request->file('image')->store('images/Latest_news', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $input['image'] = $imagePath;
            }
            $Latest_news->update($input);
            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $Latest_news]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $Latest_news = Latest_news::find($id);

        if (!$Latest_news) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $Latest_news->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
