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
        return response()->json([
            'success' => true,
            'registers' => $registers
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'register_as' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:register_ins,email',
            'phone' => 'required|string|max:15',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/registerIn', 'public');
                $imagePath = 'storage/app/public/' . $imagePath;
                $data['image'] = $imagePath;
            }
            // dd($data);
            $register = registerIn::create($data);




            return response()->json([
                'success' => true,
                'message' => 'Created successfully',
                'register' => $register
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {


        $registerIn = registerIn::find($id);

        if (!$registerIn) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
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
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
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

            return response()->json([
                'success' => true,
                'message' => 'Updated successfully',
                'register' => $registerIn
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {

        $registerIn = registerIn::find($id);

        if (!$registerIn) {
            return response()->json(['error' => 'البيانات غير موجودة'], 404);
        }


        try {
            if ($registerIn->image) {
                Storage::disk('public')->delete($registerIn->image); // Delete image if exists
            }

            $registerIn->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
