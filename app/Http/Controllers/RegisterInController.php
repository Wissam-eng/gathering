<?php

namespace App\Http\Controllers;

use App\Models\registerIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RegisterInController extends Controller
{


    public function index()
    {
        $registers = registerIn::all();
        return view('RegisterIn.index', compact('registers'));
    }


    public function create()
    {
        return view('RegisterIn.create');
    }



    public function edit($id)
    {
        $card = registerIn::find($id);
        if (!$card) {
            return redirect()->back()->with('error', 'البيانات غير موجودة');
        }

        return view('RegisterIn.edite')->with('card', $card);
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'register_as' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:register_ins,email',
            'phone' => 'required|string|max:15',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,webp,svg,jpg,gif,svg|max:10000',
        ]);

        if ($validator->fails()) {
            // return redirect()->back()->withErrors($validator)->with('error', 'Validation error');
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/registerIn', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $data['image'] = $imagePath;
            }

            $register = registerIn::create($data);

            return response()->json(['message' => 'Created successfully'], 201);

            // return redirect()->route('RegisterIn.index')->with('success', 'Created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $registerIn = registerIn::find($id);

        if (!$registerIn) {
            return redirect()->route('RegisterIn.index')->with('error', 'Data not found');
        }

        $validator = Validator::make($request->all(), [
            'register_as' => 'sometimes|string|max:255',
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|string|max:15',
            'company' => 'sometimes|string|max:255',
            'job_title' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,webp,svg,jpg,gif,svg|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation error');
        }

        try {
            $data = $request->all();

            if ($request->hasFile('image')) {
                if ($registerIn->image) {
                    Storage::disk('public')->delete($registerIn->image);
                }
                $imagePath = $request->file('image')->store('images/registerIn', 'public');
                $data['image'] = 'storage/app/public/' . $imagePath;
            }

            $registerIn->update($data);

            return redirect()->route('RegisterIn.index')->with('success', 'Updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $registerIn = registerIn::find($id);

        if (!$registerIn) {
            return redirect()->route('RegisterIn.index')->with('error', 'Data not found');
        }

        try {
            if ($registerIn->image) {
                Storage::disk('public')->delete($registerIn->image);
            }

            $registerIn->delete();

            return redirect()->route('RegisterIn.index')->with('success', 'Deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
