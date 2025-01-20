<?php

namespace App\Http\Controllers;

use App\Models\Forum_management;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForumManagementController extends Controller
{
    public function index()
    {
        try {
            $Forum_managements = Forum_management::all();
            return view('Forum_management.index', compact('Forum_managements'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }




    public function create()
    {
        return view('Forum_management.create');
    }



    public function edit($id)
    {
        $card = Forum_management::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('Forum_management.edite')->with('card', $card);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,svg,webp,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
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

            return redirect()->route('Forum_management.index')->with('success', 'تم إضافة البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $Forum_management = Forum_management::find($id);

        if (!$Forum_management) {
            return redirect()->route('Forum_management.index')->with('error', 'البيانات غير موجودة');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,svg,webp,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
        }

        try {

            $input = $request->except('image');

            if ($request->hasFile('image')) {
                if ($Forum_management->image && file_exists(public_path('storage/' . $Forum_management->image))) {
                    unlink(public_path('storage/' . $Forum_management->image));
                }
                $imagePath = $request->file('image')->store('images/Forum_management', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $Forum_management->image = $imagePath;
            }
            $Forum_management->update($input);

            return redirect()->route('Forum_management.index')->with('success', 'تم تعديل البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $Forum_management = Forum_management::find($id);

        if (!$Forum_management) {
            return redirect()->route('Forum_management.index')->with('error', 'البيانات غير موجودة');
        }

        try {
            $Forum_management->delete();
            return redirect()->route('Forum_management.index')->with('success', 'تم حذف البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage());
        }
    }
}
