<?php

namespace App\Http\Controllers;

use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SponsorshipController extends Controller
{
    public function index()
    {
        $sponsorships = Sponsorship::all();
        return view('sponsorship.index', compact('sponsorships'));
    }


    public function create()
    {
        return view('sponsorship.create');
    }



    public function edit($id)
    {
        $card = Sponsorship::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('sponsorship.edite')->with('card', $card);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'link' => 'sometimes|url',
            'image' => 'nullable|image|mimes:jpeg,png,webp,svg,jpg,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation error');
        }

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/Sponsorship', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
            }

            $sponsorship = Sponsorship::create([
                'name' => $request->input('name'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath,
                'link' => $request->input('link'),
            ]);

            return redirect()->route('sponsorship.index')->with('success', 'Sponsorship added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $sponsorship = Sponsorship::find($id);

        if (!$sponsorship) {
            return redirect()->route('sponsorship.index')->with('error', 'Data not found');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'link' => 'sometimes|url',
            'image' => 'nullable|image|mimes:jpeg,png,webp,svg,jpg,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation error');
        }

        try {
            $input = $request->all();

            if ($request->hasFile('image')) {
                if ($sponsorship->image && file_exists(public_path('storage/' . $sponsorship->image))) {
                    unlink(public_path('storage/' . $sponsorship->image));
                }
                $imagePath = $request->file('image')->store('images/Sponsorship', 'public');
                $input['image'] = 'storage/app/public/' . $imagePath;
            }

            $sponsorship->update($input);

            return redirect()->route('sponsorship.index')->with('success', 'Sponsorship updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $sponsorship = Sponsorship::find($id);

        if (!$sponsorship) {
            return redirect()->route('sponsorship.index')->with('error', 'Data not found');
        }

        try {
            if ($sponsorship->image) {
                Storage::disk('public')->delete($sponsorship->image);
            }

            $sponsorship->delete();

            return redirect()->route('sponsorship.index')->with('success', 'Sponsorship deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
