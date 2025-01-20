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
            return view('contct_footer.index', compact('contct_footers'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }




    public function create()
    {
        return view('contct_footer.create');
    }



    public function edit($id)
    {
        $card = contct_footer::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('contct_footer.edite')->with('card', $card);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'whatsapp' =>  'nullable|string|max:255',
            'email' => 'nullable|string|email',
            'website' => 'nullable|string|url',
            'facebook' => 'nullable|string|url',
            'instagram' => 'nullable|string|url',
            'twitter' => 'nullable|string|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
        }

        try {


            $contactFooter = contct_footer::create([
                'phone' => $request->input('phone'),
                'whatsapp' => $request->input('whatsapp'),
                'location' => $request->input('location'),
                'email' => $request->input('email'),
                'website' => $request->input('website'),
                'facebook' => $request->input('facebook'),
                'instagram' => $request->input('instagram'),
                'twitter' => $request->input('twitter'),
            ]);

            return redirect()->route('contct_footer.index')->with('success', 'تم إضافة البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $contactFooter = contct_footer::find($id);

        if (!$contactFooter) {
            return redirect()->route('contct_footer.index')->with('error', 'البيانات غير موجودة');
        }

        $validator = Validator::make($request->all(), [
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'whatsapp' =>  'nullable|string|max:255',
            'email' => 'nullable|string|email',
            'website' => 'nullable|string|url',
            'facebook' => 'nullable|string|url',
            'instagram' => 'nullable|string|url',
            'twitter' => 'nullable|string|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'التحقق من البيانات فشل');
        }

        try {
          

            $contactFooter->update([
                'phone' => $request->input('phone'),
                'whatsapp' => $request->input('whatsapp'),
                'location' => $request->input('location'),
                'email' => $request->input('email'),
                'website' => $request->input('website'),
                'facebook' => $request->input('facebook'),
                'instagram' => $request->input('instagram'),
                'twitter' => $request->input('twitter'),
            ]);

            return redirect()->route('contct_footer.index')->with('success', 'تم تعديل البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $contactFooter = contct_footer::find($id);

        if (!$contactFooter) {
            return redirect()->route('contct_footer.index')->with('error', 'البيانات غير موجودة');
        }

        try {
            $contactFooter->delete();
            return redirect()->route('contct_footer.index')->with('success', 'تم حذف البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage());
        }
    }
}
