<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\supervisor_speech;
use Illuminate\Http\Request;

class SupervisorSpeechController extends Controller
{
    public function index()
    {
        $supervisor_speechs = supervisor_speech::all();
        return view('supervisor_speech.index', compact('supervisor_speechs'));
    }


    public function create()
    {
        return view('supervisor_speech.create');
    }



    public function edit($id)
    {
        $card = supervisor_speech::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('supervisor_speech.edite')->with('card', $card);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,svg ,webp,png,jpg,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation error');
        }

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/supervisor_speech', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
            }

            $supervisor_speech = supervisor_speech::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath,
                'address' => $request->input('address'),
                'date' => $request->input('date'),
                'text' => $request->input('text'),
            ]);

            return redirect()->route('supervisor_speech.index')->with('success', 'Supervisor speech added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $supervisor_speech = supervisor_speech::find($id);

        if (!$supervisor_speech) {
            return redirect()->route('supervisor_speech.index')->with('error', 'Data not found');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,webp,svg,jpg,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation error');
        }

        try {
            $input = $request->all();

            if ($request->hasFile('image')) {
                if ($supervisor_speech->image && file_exists(public_path('storage/' . $supervisor_speech->image))) {
                    unlink(public_path('storage/' . $supervisor_speech->image));
                }
                $imagePath = $request->file('image')->store('images/supervisor_speech', 'public');
                $input['image'] = 'storage/app/public/' . $imagePath;
            }

            $supervisor_speech->update($input);

            return redirect()->route('supervisor_speech.index')->with('success', 'Supervisor speech updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $supervisor_speech = supervisor_speech::find($id);

        if (!$supervisor_speech) {
            return redirect()->route('supervisor_speech.index')->with('error', 'Data not found');
        }

        try {
            $supervisor_speech->delete();

            return redirect()->route('supervisor_speech.index')->with('success', 'Supervisor speech deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
