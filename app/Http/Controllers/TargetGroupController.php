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
        return view('target_group.index', compact('target_groups'));
    }



    public function create()
    {
        return view('target_group.create');
    }



    public function edit($id)
    {
        $card = target_group::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('target_group.edite')->with('card', $card);
    }






    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation error');
        }

        try {
            $target_group = target_group::create([
                'title' => $request->input('title'),
            ]);

            return redirect()->route('target_group.index')->with('success', 'Target group added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $target_group = target_group::find($id);

        if (!$target_group) {
            return redirect()->route('target_group.index')->with('error', 'Data not found');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation error');
        }

        try {
            $target_group->update($request->all());

            return redirect()->route('target_group.index')->with('success', 'Target group updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $target_group = target_group::find($id);

        if (!$target_group) {
            return redirect()->route('target_group.index')->with('error', 'Data not found');
        }

        try {
            $target_group->delete();
            return redirect()->route('target_group.index')->with('success', 'Target group deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
