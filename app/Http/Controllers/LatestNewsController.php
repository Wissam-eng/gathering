<?php

namespace App\Http\Controllers;

use App\Models\Latest_news;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LatestNewsController extends Controller
{
    public function index()
    {
        try {
            $Latest_newss = Latest_news::all();
            return view('latest_news.index', compact('Latest_newss'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }






    public function create()
    {
        return view('latest_news.create');
    }



    public function edit($id)
    {
        $card = Latest_news::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('latest_news.edite')->with('card', $card);
    }








    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
        }

        try {
            $imagePath = null;

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

            return redirect()->route('latest_news.index')->with('success', 'تم إضافة البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $Latest_news = Latest_news::find($id);

        if (!$Latest_news) {
            return redirect()->route('latest_news.index')->with('error', 'البيانات غير موجودة');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date_format:Y-m-d',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
        }

        try {
            $input = $request->all();

            if ($request->hasFile('image')) {
                if ($Latest_news->image && file_exists(public_path('storage/' . $Latest_news->image))) {
                    unlink(public_path('storage/' . $Latest_news->image));
                }
                $imagePath = $request->file('image')->store('images/Latest_news', 'public');
                $input['image'] = 'storage/app/public/' . $imagePath;
            }

            $Latest_news->update($input);

            return redirect()->route('latest_news.index')->with('success', 'تم تعديل البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $Latest_news = Latest_news::find($id);

        if (!$Latest_news) {
            return redirect()->route('latest_news.index')->with('error', 'البيانات غير موجودة');
        }

        try {
            $Latest_news->delete();
            return redirect()->route('latest_news.index')->with('success', 'تم حذف البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage());
        }
    }
}
