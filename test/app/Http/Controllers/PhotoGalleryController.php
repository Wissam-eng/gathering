<?php

namespace App\Http\Controllers;

use App\Models\Photo_gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PhotoGalleryController extends Controller
{
    public function index()
    {
        try {
            // إنشاء المصفوفة الكبيرة المطلوبة
            $photoGalleries = Photo_gallery::all()
                ->groupBy('code') // تجميع العناصر حسب الكود
                ->map(function ($group, $code) {
                    return [
                        // الكود كعنصر رئيسي
                        'code' => $code,            // الكود كعنصر رئيسي
                        'cover' => $group->first()->cover,
                        'title' => $group->first()->title,
                        'images' => $group->pluck('image')->toArray(), // كل الصور المتعلقة بالكود
                    ];
                })
                ->values() // إعادة تعيين المفاتيح لتكون متسلسلة (مصفوفة كبيرة)
                ->toArray();

            // $photoGalleries = Photo_gallery::all();

            // dd($photoGalleries);
            return view('photo_gallery.index', compact('photoGalleries'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }





    public function create()
    {
        return view('photo_gallery.create');
    }



    public function edit($id)
    {
        try {
            $photos = Photo_gallery::where('code', $id)->get();

            if ($photos->isEmpty()) {
                return redirect()->back()->with('error', 'البيانات غير موجودة');
            }

            $card = $photos->groupBy('code')
                ->map(function ($group, $code) {
                    return [
                        'code' => $code,
                        'cover' => $group->first()->cover,
                        'title' => $group->first()->title,
                        'images' => $group->pluck('image')->toArray(),
                    ];
                })
                ->first();



            return view('photo_gallery.edite')->with('card', $card);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }




    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,svg,webp,jpg,gif|max:100000',
            'cover' => 'required|image|mimes:jpeg,svg,webp,png,jpg,gif|max:100000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        try {
            $code = Str::random(10);
            $imagePaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images/Photo_gallery/cover' . $code, 'public');
                    $imagePaths[] = 'storage/app/public/' . $imagePath;
                }
            }

            if ($request->hasFile('cover')) {
                $cover = $request->file('cover');

                $coverPath = $cover->store('images/Photo_gallery/cover' . $code, 'public');
                $coverPath = 'storage/app/public/' . $coverPath;
            } else {
                return redirect()->back()->with('error', 'الكوفير مطلوب');
            }

            foreach ($imagePaths as $imagePath) {
                Photo_gallery::create([
                    'image' => $imagePath,
                    'cover' => $coverPath,
                    'code' => $code,
                    'title' => $request->title,
                ]);
            }

            return redirect()->route('photo_gallery.index')->with('success', 'تم إضافة البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $code)
    {
        $photoGalleries = Photo_gallery::where('code', $code)->get();

        if ($photoGalleries->isEmpty()) {
            return redirect()->route('photo_gallery.index')->with('error', 'لا توجد بيانات لهذا الكود');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'images' => 'array|min:1',
            'images.*' => 'image|mimes:jpeg,png,svg,webp,jpg,gif|max:100000',
            'cover' => 'image|mimes:jpeg,png,svg,webp,jpg,gif|max:100000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        try {
            if ($request->hasFile('cover')) {
                $currentCover = $photoGalleries->first()->cover;
                if (file_exists(public_path($currentCover))) {
                    unlink(public_path($currentCover));
                }

                $coverPath = $request->file('cover')->store('images/Photo_gallery/cover', 'public');
                $coverPath = 'storage/app/public/' . $coverPath;

                // Update the cover for the first gallery only (assuming it's the shared cover)
                $photoGalleries->first()->cover = $coverPath;
                $photoGalleries->first()->save();
            }

            if ($request->hasFile('images')) {
                // Delete old images
                foreach ($photoGalleries as $gallery) {
                    if (file_exists(public_path($gallery->image))) {
                        unlink(public_path($gallery->image));
                    }
                    $gallery->delete();
                }

                // Save new images
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images/Photo_gallery', 'public');
                    $imagePath = 'storage/app/public/' . $imagePath;

                    Photo_gallery::create([
                        'cover' => isset($coverPath) ? $coverPath : $photoGalleries->first()->cover,
                        'image' => $imagePath,
                        'code' => $code,
                        'title' => $request->title,
                    ]);
                }
            } else {
                // If no new images, just update the title
                foreach ($photoGalleries as $gallery) {
                    $gallery->title = $request->title;
                    $gallery->save();
                }
            }

            return redirect()->route('photo_gallery.index')->with('success', 'تم تعديل البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $photoGallery = Photo_gallery::where('code', $id)->get();

        if (!$photoGallery) {
            return redirect()->route('photo_gallery.index')->with('error', 'البيانات غير موجودة');
        }

        try {
            foreach ($photoGallery as $gallery) {

                $gallery->delete();
            }
            return redirect()->route('photo_gallery.index')->with('success', 'تم حذف البيانات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage());
        }
    }
}
