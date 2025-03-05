<?php

namespace App\Http\Controllers;

use App\Models\Key_speakers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeySpeakersController extends Controller
{
    public function index()
    {
        try {
            $Key_speakerss = Key_speakers::all();
            return view('key_speakers.index', compact('Key_speakerss'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }




    public function create()
    {
        return view('key_speakers.create');
    }



    public function edit($id)
    {
        $card = Key_speakers::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('key_speakers.edite')->with('card', $card);
    }


    public function store(Request $request)
    {
        // dd($request->all());
       $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,svg,webp,png,jpg,gif|max:10000',
            'file' => 'nullable|mimes:pdf,xlsx,doc,docx,txt|max:10000',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', $validator->fails() .'التحقق من البيانات فشل');
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
                'image' => $imagePath ?? null,
                'file' => $filePath ?? null,
                // 'address' => $request->input('address'),
                // 'date' => $request->input('date'),
                // 'text' => $request->input('text'),
            ]);

            return redirect()->route('key_speakers.index')->with('success', 'تم إضافة البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $Key_speakers = Key_speakers::find($id);

        if (!$Key_speakers) {
            return redirect()->route('key_speakers.index')->with('error', 'البيانات غير موجودة');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,svg ,webp,png,jpg,gif|max:10000',
            'file' => 'nullable|mimes:pdf,xlsx,doc,docx,txt|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
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

            return redirect()->route('key_speakers.index')->with('success', 'تم تعديل البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $Key_speakers = Key_speakers::find($id);

        if (!$Key_speakers) {
            return redirect()->route('key_speakers.index')->with('error', 'البيانات غير موجودة');
        }

        try {
            $Key_speakers->delete();
            return redirect()->route('key_speakers.index')->with('success', 'تم حذف البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage());
        }
    }
}
