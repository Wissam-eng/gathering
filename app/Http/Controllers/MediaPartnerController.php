<?php

namespace App\Http\Controllers;

use App\Models\Media_partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MediaPartnerController extends Controller
{
    public function index()
    {
        try {
            $Media_partners = Media_partner::all();
            return view('media_partner.index', compact('Media_partners'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }






    public function create()
    {
        return view('Media_partner.create');
    }



    public function edit($id)
    {
        $card = Media_partner::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('Media_partner.edite')->with('card', $card);
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
                $imagePath = $request->file('image')->store('images/Media_partner', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
            }

            $Media_partner = Media_partner::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath ?? null,
                'address' => $request->input('address'),
                'date' => $request->input('date'),
                'text' => $request->input('text'),
            ]);

            return redirect()->route('media_partner.index')->with('success', 'تم إضافة البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $Media_partner = Media_partner::find($id);

        if (!$Media_partner) {
            return redirect()->route('media_partner.index')->with('error', 'البيانات غير موجودة');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
        }

        try {
            $input = $request->all();

            if ($request->hasFile('image')) {
                if ($Media_partner->image && file_exists(public_path('storage/' . $Media_partner->image))) {
                    unlink(public_path('storage/' . $Media_partner->image));
                }
                $imagePath = $request->file('image')->store('images/Media_partner', 'public');
                $input['image'] = 'storage/app/public/' . $imagePath;
            }

            $Media_partner->update($input);

            return redirect()->route('media_partner.index')->with('success', 'تم تعديل البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $Media_partner = Media_partner::find($id);

        if (!$Media_partner) {
            return redirect()->route('media_partner.index')->with('error', 'البيانات غير موجودة');
        }

        try {
            $Media_partner->delete();
            return redirect()->route('media_partner.index')->with('success', 'تم حذف البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage());
        }
    }
}
