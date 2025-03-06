<?php

namespace App\Http\Controllers;

use App\Models\TitleWeb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TitleWebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // جلب جميع السجلات من قاعدة البيانات
        $allRecords = TitleWeb::all();
        // إرجاع السجلات كـ JSON
        return response()->json([
            'message' => 'All records retrieved successfully.',
            'data' => $allRecords,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TitleWeb $titleWeb)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $titleWeb = TitleWeb::findOrFail(1); // تعديل حسب المطلوب
        return view('tilte_web.edit', compact('titleWeb'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
     //   dd($request->all());

        // تحديد شروط التحقق
        $validator = Validator::make($request->all(), [
            // 'title_introduce' => 'nullable|string|max:255',
            'title_goals' => 'nullable|string|max:255',
            'title_Sponsorships' => 'nullable|string|max:255',
            'title_Gallery' => 'nullable|string|max:255',
            'title_FeaturedSpeakers' => 'nullable|string|max:255',
            'title_MediaPartner' => 'nullable|string|max:255',
            'title_TargetGroup' => 'nullable|string|max:255',
            'title_ForumManagement' => 'nullable|string|max:255',
            'title_Organizer' => 'nullable|string|max:255',
            'title_LATEST_NEWS' => 'nullable|string|max:255',
        ]);

        // التحقق من فشل الفاليديتور
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed!',
                'errors' => $validator->errors(),
            ], 422); // كود HTTP 422 يعني Unprocessable Entity
        }

        // البحث عن السجل
        $titleWeb = TitleWeb::findOrFail(1);

        // تحديث الحقول
        $titleWeb->update($request->only([
            'title_goals',
            'title_Sponsorships',
            'title_Gallery',
            'title_FeaturedSpeakers',
            'title_MediaPartner',
            'title_TargetGroup',
            'title_ForumManagement',
            'title_Organizer',
            'title_LATEST_NEWS',
        ]));

        // استجابة JSON عند النجاح
        return redirect()->back()->with('success', 'تم التحديث بنجاح!');

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TitleWeb $titleWeb)
    {
        //
    }
}
