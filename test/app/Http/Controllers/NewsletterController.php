<?php

namespace App\Http\Controllers;

use App\Models\newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{

    public function index()
    {
        $newsletters = newsletter::all();
        return view('newsletters.index', compact('newsletters'));
    }


    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletters,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        Newsletter::create([
            'email' => $request->input('email'),
        ]);

        return response()->json([
            'success' => 'تم التسجيل بنجاح'
        ]);
    }





    public function update(Request $request, $id)
    {
        $newsletter = newsletter::find($id);

        if (!$newsletter) {
            return response()->json(['error' => 'البريد الالكتروني غير موجود'], 404);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletters,email,' . $newsletter->id,
        ]);


        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $newsletter->update([
            'email' => $request->input('email'),
        ]);

        return response()->json(['success' => 'تم التعديل بنجاح']);
    }


    public function destroy($id)
    {
        $newsletter = newsletter::find($id);

        if (!$newsletter) {
            return response()->json(['error' => 'البريد الالكتروني غير موجود'], 404);
        }

        $newsletter->forceDelete();

        return response()->json(['success' => 'تم الحذف بنجاح']);
    }
}
