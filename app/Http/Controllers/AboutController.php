<?php

namespace App\Http\Controllers;

use App\Models\about;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
{

    public function index()
    {
        try {
            $abouts = about::all();
            return view('about.index', compact('abouts'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'البيانات غير موجودة: ' . $e->getMessage());
        }
    }


    public function create()
    {
        return view('about.create');
    }

    public function edit($id)
    {

        $card = about::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('about.edite')->with('card', $card);
    }




    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,svg,webp,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
        }

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/about', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
            }

            $about = about::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath ?? null,
                'address' => $request->input('address'),
                'date' => $request->input('date'),
                'text' => $request->input('text'),
            ]);

            return redirect()->route('about.index')->with('success', 'تم إضافة البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $about = about::find($id);


        if (!$about) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,svg,webp,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
        }

        try {
            if ($request->hasFile('image')) {
                if ($about->image && file_exists(public_path('storage/' . $about->image))) {
                    unlink(public_path('storage/' . $about->image));
                }
                $imagePath = $request->file('image')->store('images/about', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $input['image'] = $imagePath;
            }
            $about->update($input);
            return redirect()->route('about.index')->with('success', 'تم تعديل البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $about = about::find($id);

        if (!$about) {
            return redirect()->route('about.index')->with('error', 'البيانات غير موجودة');
        }

        try {
            $about->delete();
            return redirect()->route('about.index')->with('success', 'تم حذف البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage());
        }
    }
}
