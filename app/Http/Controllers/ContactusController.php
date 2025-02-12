<?php

namespace App\Http\Controllers;

use App\Models\contactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ContactusController extends Controller
{

    public function index()
    {
        $contactus = contactus::all();
        return view('contact.index', compact('contactus'));
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contactuses,email',
            'mobile' => 'required|string',
            'goal' => 'required|string|in:suggested,complaint,inquiry',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $contactus = contactus::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'goal' => $request->input('goal'),
        ]);

        return response()->json([
            'success' => 'تم التسجيل بنجاح'
        ]);
    }


    public function update(Request $request, $id)
    {
        $contactus = contactus::find($id);

        if (!$contactus) {
            return redirect()->route('contactus.index')->with('error', 'Data not found');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required|string',
            'goal' => 'required|string|in:suggested,complaint,inquiry',
        ]);

        if ($validator->fails()) {
            return redirect()->route('contactus.index')->with('error', 'Validation error');
        }

        $contactus->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'goal' => $request->input('goal'),
        ]);

        return redirect()->route('contactus.index')->with('success', 'Data updated successfully');
    }


    public function destroy($id)
    {
        $contactus = contactus::find($id);

        if (!$contactus) {
            return redirect()->route('contactus.index')->with('error', 'Data not found');
        }

        $contactus->forceDelete();

        return redirect()->route('contactus.index')->with('success', 'Data deleted successfully');
    }


    public function export_contact(Request $request){
        
    }
}
