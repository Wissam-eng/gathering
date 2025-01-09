<?php

namespace App\Http\Controllers;

use App\Models\contct_footer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContctFooterController extends Controller
{
    public function index()
    {
        try {
            $contct_footers = contct_footer::all();
            return response()->json(['success' => true, 'contct_footer' => $contct_footers]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage()], 500);
        }
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location' => 'nullable|string',
            'phone' => 'nullable|array',
            'whatsapp' => 'nullable|array',
            'email' => 'nullable|string|email',
            'website' => 'nullable|string|url',
            'facebook' => 'nullable|string|url',
            'instagram' => 'nullable|string|url',
            'twitter' => 'nullable|string|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            $phoneNumbers = $request->input('phone') ? implode(',', $request->input('phone')) : null;
            $whatsappNumbers = $request->input('whatsapp') ? implode(',', $request->input('whatsapp')) : null;

            $contactFooter = contct_footer::create([
                'phone' => $phoneNumbers,
                'whatsapp' => $whatsappNumbers,
                'location' => $request->input('location'),
                'email' => $request->input('email'),
                'website' => $request->input('website'),
                'facebook' => $request->input('facebook'),
                'instagram' => $request->input('instagram'),
                'twitter' => $request->input('twitter'),
            ]);

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $contactFooter], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }





    public function update(Request $request, $id)
    {
        $contactFooter = contct_footer::find($id);

        if (!$contactFooter) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        $validator = Validator::make($request->all(), [
            'location' => 'nullable|string',
            'phone' => 'nullable|array',
            'whatsapp' => 'nullable|array',
            'email' => 'nullable|string|email',
            'website' => 'nullable|string|url',
            'facebook' => 'nullable|string|url',
            'instagram' => 'nullable|string|url',
            'twitter' => 'nullable|string|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            $phoneNumbers = $request->input('phone') ? implode(',', $request->input('phone')) : $contactFooter->phone;
            $whatsappNumbers = $request->input('whatsapp') ? implode(',', $request->input('whatsapp')) : $contactFooter->whatsapp;

            $contactFooter->update([
                'location' => $request->input('location', $contactFooter->location),
                'phone' => $phoneNumbers,
                'whatsapp' => $whatsappNumbers,
                'email' => $request->input('email', $contactFooter->email),
                'website' => $request->input('website', $contactFooter->website),
                'facebook' => $request->input('facebook', $contactFooter->facebook),
                'instagram' => $request->input('instagram', $contactFooter->instagram),
                'twitter' => $request->input('twitter', $contactFooter->twitter),
            ]);

            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $contactFooter]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $contct_footer = contct_footer::find($id);

        if (!$contct_footer) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $contct_footer->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
