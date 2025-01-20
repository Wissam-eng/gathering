<?php

namespace App\Http\Controllers;

use App\Models\organizing_entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizingEntityController extends Controller
{
    public function index()
    {
        try {
            $organizing_entitys = organizing_entity::all();
            return view('organizing_entity.index', compact('organizing_entitys'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }



    public function create()
    {
        return view('organizing_entity.create');
    }



    public function edit($id)
    {
        $card = organizing_entity::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('organizing_entity.edite')->with('card', $card);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
        }

        try {
            $imagePath = null;

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

            return redirect()->route('organizing_entity.index')->with('success', 'تم إضافة البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $organizing_entity = organizing_entity::find($id);

        if (!$organizing_entity) {
            return redirect()->route('organizing_entity.index')->with('error', 'البيانات غير موجودة');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,svg,webp,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
        }

        try {
            $input = $request->all();

            if ($request->hasFile('image')) {
                if ($organizing_entity->image && file_exists(public_path('storage/' . $organizing_entity->image))) {
                    unlink(public_path('storage/' . $organizing_entity->image));
                }
                $imagePath = $request->file('image')->store('images/organizing_entity', 'public');
                $input['image'] = 'storage/app/public/' . $imagePath;
            }

            $organizing_entity->update($input);

            return redirect()->route('organizing_entity.index')->with('success', 'تم تعديل البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $organizing_entity = organizing_entity::find($id);

        if (!$organizing_entity) {
            return redirect()->route('organizing_entity.index')->with('error', 'البيانات غير موجودة');
        }

        try {
            $organizing_entity->delete();
            return redirect()->route('organizing_entity.index')->with('success', 'تم حذف البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage());
        }
    }
}
