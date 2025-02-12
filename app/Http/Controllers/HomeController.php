<?php

namespace App\Http\Controllers;

use App\Models\home;
use App\Models\header;
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
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        try {

            $main = home::all();

            return view('main.index', compact('main'));
        } catch (\Exception $e) {
            // return response()->json(['error' => 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage()], 500);
            return redirect()->back()->with('error', 'البيانات غير موجودة'  . $e->getMessage());
        }
    }


    public function users()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }



    public function members()
    {
        $members = registerIn::all();
        return view('members.index', compact('members'));
    }



    public function profile()
    {
        $profile = User::find(auth()->user()->id);
        return view('profile.index', compact('profile'));
    }





    public function dashboard()
    {
        return redirect()->route('main.index');
    }



    public function register()
    {
        return view('users.create');
    }


    public function store_user(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:1|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', 'حدث خطاء اثناء التسجيل: ' . $validator->errors());
            }


            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->back()->with([
                'success' => 'تم التسجيل بنجاح user :' . $user->email . ' password :' . $request->password

            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطاء اثناء التسجيل: ' . $e->getMessage());
        }
    }



    public function update_profile(Request $request)
    {
        try {

            $user = User::find($request->id);

            if (!$user) {
                return redirect()->back()->with('error', 'البيانات غير موجودة');
            }


            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'img' => 'image|mimes:jpeg,svg,jpg,webp,png,jpg,gif|max:2048',
                'email' => 'sometimes|email',
                'password' => 'nullable|string|min:1',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', 'حدث خطاء اثناء التسجيل: ' . $validator->errors());
            }


            if($request->has('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('img')) {
                $imagePath = $request->file('img')->store('images/users', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $user->img = $imagePath;
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return redirect()->back()->with([
                'success' => 'تم تحديث البيانات بنجاح'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطاء اثناء تحديث البيانات: ' . $e->getMessage());
        }
    }






    public function create()
    {
        return view('main.create');
    }

    public function edit($id)
    {
        $card = home::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('main.edite')->with('card', $card);
    }



    public function home()
    {
        try {
            $homes = home::all();
            $header = header::all();
            $video_gallery = video_gallery::all();
            $target_group = target_group::all();
            $supervisor_speech = supervisor_speech::all();
            $Sponsorship = Sponsorship::all();

            $Photo_gallery = Photo_gallery::all()
                ->groupBy('code')
                ->map(function ($group) {
                    $cover = $group->first()->cover;
                    $title = $group->first()->title;

                    $images = $group->pluck('image');

                    return [
                        'title' => $title,
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

            return response()->json([
                'success' => true,

                'main' => $homes,
                'header' => $header,
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
            // return response()->json(['error' => 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage()], 500);
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات:'  . $e->getMessage());
        }
    }





    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,svg,webp,png,jpg,gif|max:2048',
            'address' => 'nullable|string',
            'from' => 'nullable|string',
            'text' => 'nullable|string',
            'to' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'التحقق من البيانات فشل',
                'details' => $validator->errors()
            ], 400);
        }

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/main', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $input['image'] = $imagePath;
            }

            $home = Home::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath,
                'address' => $request->input('address'),
                'from' => $request->input('from'),
                'text' => $request->input('text'),
                'to' => $request->input('to'),
            ]);



            return redirect()->route('main.index')->with('message', 'تم اضافة البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {

        // dd($request->all());
        $home = home::find($id);

        if (!$home) {
            // return response()->json(['error' => 'البيانات غير موجودة'], 404);
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'sometimes|string',
            'date' => 'sometimes|date',
            'text' => 'sometimes|string',
            'from' => 'sometimes|string',
            'to' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف البيانات: ' . $validator->errors());
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
            return redirect()->route('main.index')->with('message', 'تم تعديل البيانات بنجاح');
        } catch (\Exception $e) {
            // return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage());
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
            return redirect()->route('main.index')->with('message', 'تم حذف البيانات بنجاح');
        } catch (\Exception $e) {
            // return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);

            return redirect()->route('main.index')->with('error', 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage());
        }
    }
}
