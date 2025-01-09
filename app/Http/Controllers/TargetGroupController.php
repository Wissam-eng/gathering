<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use App\Models\target_group;
use Illuminate\Http\Request;

class TargetGroupController extends Controller
{
    public function index()
    {

        $target_groups = target_group::all();
        return response()->json(['success' => true, 'target_groups' => $target_groups]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {



            $target_group = target_group::create([
                'title' => $request->input('title'),

            ]);

            return response()->json(['success' => 'تم إضافة البيانات بنجاح', 'data' => $target_group], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {

        $target_group = target_group::find($id);

        if (!$target_group) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'التحقق من البيانات فشل', 'details' => $validator->errors()], 400);
        }

        try {

            $target_group->update($input);
            return response()->json(['success' => 'تم تعديل البيانات بنجاح', 'data' => $target_group]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء تعديل البيانات: ' . $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $target_group = target_group::find($id);

        if (!$target_group) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }

        try {
            $target_group->delete();
            return response()->json(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف البيانات: ' . $e->getMessage()], 500);
        }
    }
}
