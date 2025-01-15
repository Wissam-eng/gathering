<?php

namespace App\Http\Controllers;

use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SponsorshipController extends Controller
{
    public function index()
    {

        $Sponsorships = Sponsorship::all();
        return response()->json(['success' => true, 'Sponsorships' => $Sponsorships]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'link' => 'sometimes|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/Sponsorship', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
            }

            $Sponsorship = Sponsorship::create([
                'name' => $request->input('name'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath ?? null,
                'link' => $request->input('link'),

            ]);

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $Sponsorship], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {

        $Sponsorship = Sponsorship::find($id);

        if (!$Sponsorship) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'link' => 'sometimes|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            if ($request->hasFile('image')) {
                if ($Sponsorship->image && file_exists(public_path('storage/' . $Sponsorship->image))) {
                    unlink(public_path('storage/' . $Sponsorship->image));
                }
                $imagePath = $request->file('image')->store('images/Sponsorship', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $input['image'] = $imagePath;
            }
            $Sponsorship->update($input);
            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $Sponsorship]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $Sponsorship = Sponsorship::find($id);

        if (!$Sponsorship) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $Sponsorship->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
