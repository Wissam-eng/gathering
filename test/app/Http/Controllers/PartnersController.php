<?php

namespace App\Http\Controllers;

use App\Models\partners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartnersController extends Controller
{
    public function index()
    {
        try {
            $partnerss = partners::all();
            return view('partners.index', compact('partnerss'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }





    public function create()
    {
        return view('partners.create');
    }



    public function edit($id)
    {
        $card = partners::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('partners.edite')->with('card', $card);
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,webp,svg,jpg,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
        }

        try {
            $imagePaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images/partners', 'public');
                    $imagePaths[] = 'storage/app/public/' . $imagePath;
                }
            }

            foreach ($imagePaths as $imagePath) {
                partners::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'image' => $imagePath,
                ]);
            }

            return redirect()->route('partners.index')->with('success', 'تم إضافة البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        //  dd($request->title);
        $partners = partners::find($id);

        if (!$partners) {
            return redirect()->route('partners.index')->with('error', 'البيانات غير موجودة');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'images' => 'image|mimes:jpeg,png,svg,webp,jpg,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
        }

        try {


            if ($request->hasFile('images')) {
                if (file_exists(public_path('storage/' . $partners->image))) {
                    unlink(public_path('storage/' . $partners->image));
                }

                $image = $request->file('images');
                $imagePath = $image->store('images/partners', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;

                $partners->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'image' => $imagePath,
                ]);
            }
                $partners->update([
                    'title' => $request->title,
                    'description' => $request->description,
                ]);

            return redirect()->route('partners.index')->with('success', 'تم تعديل البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $partners = partners::find($id);

        if (!$partners) {
            return redirect()->route('partners.index')->with('error', 'البيانات غير موجودة');
        }

        try {
            $partners->delete();
            return redirect()->route('partners.index')->with('success', 'تم حذف البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage());
        }
    }
}
