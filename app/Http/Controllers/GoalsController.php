<?php

namespace App\Http\Controllers;

use App\Models\goals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GoalsController extends Controller
{
    public function index()
    {
        try {
            $goals = goals::all();
            return view('goals.index', compact('goals'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }



    public function create()
    {
        return view('goals.create');
    }



    public function edit($id)
    {
        $card = goals::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('goals.edite')->with('card', $card);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,svg,webp,jpg,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
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

            return redirect()->route('goals.index')->with('success', 'تم إضافة البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $goals = goals::find($id);

        if (!$goals) {
            return redirect()->route('goals.index')->with('error', 'البيانات غير موجودة');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,svg,webp,jpg,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
        }

        try {

            $input = $request->except('image');
            if ($request->hasFile('image')) {
                if ($goals->image && file_exists(public_path('storage/' . $goals->image))) {
                    unlink(public_path('storage/' . $goals->image));
                }
                $imagePath = $request->file('image')->store('images/goals', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $goals->image = $imagePath;
            }


            $goals->update($input);

            return redirect()->route('goals.index')->with('success', 'تم تعديل البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $goals = goals::find($id);

        if (!$goals) {
            return redirect()->route('goals.index')->with('error', 'البيانات غير موجودة');
        }

        try {
            $goals->delete();
            return redirect()->route('goals.index')->with('success', 'تم حذف البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage());
        }
    }
}
