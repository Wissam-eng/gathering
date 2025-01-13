<?php

namespace App\Http\Controllers;

use App\Models\home;
use App\Models\video_gallery;
use App\Models\target_group;
use App\Models\supervisor_speech;
use App\Models\Sponsorship;
use App\Models\registerIn;
use App\Models\Photo_gallery;
use App\Models\partners;
use App\Models\organizing_entity;
use App\Models\Latest_news;
use App\Models\Media_partner;
use App\Models\Key_speakers;
use App\Models\goals;
use App\Models\Forum_management;
use App\Models\contct_footer;
use App\Models\about;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $homes = home::all();
            return response()->json(['success' => true, 'main' => $homes]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage()], 500);
        }
    }



    public function home()
    {
        try {
            $homes = home::all();
            $video_gallery = video_gallery::all();
            $target_group = target_group::all();
            $supervisor_speech = supervisor_speech::all();
            $Sponsorship = Sponsorship::all();

            $Photo_gallery = Photo_gallery::all()
            ->groupBy('code')
            ->map(function ($group) {
                $cover = $group->first()->cover;

                $images = $group->pluck('image');

                return [
                    'cover' => $cover,
                    'images' => $images,
                ];
            });
            $partners = partners::all();
            $organizing_entity = organizing_entity::all();
            $Latest_news = Latest_news::all();
            $Media_partner = Media_partner::all();
            $Key_speakers = Key_speakers::all();
            $Forum_management = Forum_management::all();
            $goals = goals::all();
            $contct_footer = contct_footer::all();
            $about = about::all();

            return response()->json(['success' => true,

            'main' => $homes,
            'about' => $about,
            'goals' => $goals,
            'target_group' => $target_group,
            'supervisor_speech' => $supervisor_speech,
            'organizing_entity' => $organizing_entity,
            'Forum_management' => $Forum_management,
            'Media_partner' => $Media_partner,
            'Key_speakers' => $Key_speakers,
            'Sponsorship' => $Sponsorship,
            'Latest_news' => $Latest_news,
            'Photo_gallery' => $Photo_gallery,
             'video_gallery' => $video_gallery,
             'partners' => $partners,
             'contct_footer' => $contct_footer,

            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage()], 500);
        }
    }







    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string',
            'date' => 'nullable|date',
            'text' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/main', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
            }

            $home = home::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath ?? null,
                'address' => $request->input('address'),
                'date' => $request->input('date'),
                'text' => $request->input('text'),
            ]);

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $home], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {

        $home = home::find($id);

        if (!$home) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'sometimes|string',
            'date' => 'sometimes|date',
            'text' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {
            if ($request->hasFile('image')) {
                if ($home->image && file_exists(public_path('storage/' . $home->image))) {
                    unlink(public_path('storage/' . $home->image));
                }
                $imagePath = $request->file('image')->store('images/main', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $input['image'] = $imagePath;
            }
            $home->update($input);
            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $home]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $home = home::find($id);

        if (!$home) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $home->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
