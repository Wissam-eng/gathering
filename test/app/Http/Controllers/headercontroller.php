<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\header;

class headercontroller extends Controller
{
    public function index()
    {
        $header = header::all();
        return view('header.index', compact('header'));
    }

    public function create()
    {
        return view('header.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'header_value1' => 'nullable|array',
            'header_value2' => 'nullable|array',
            'header_value3' => 'nullable|array',
            'header_value4' => 'nullable|array',
            'header_value5' => 'nullable|array',
            'header_value6' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'حدث خطاء اثناء التسجيل: ' . $validator->errors());
        }

        $headerData = array_filter([
            'header_value1' => $request->input('header_value1'),
            'header_value2' => $request->input('header_value2'),
            'header_value3' => $request->input('header_value3'),
            'header_value4' => $request->input('header_value4'),
            'header_value5' => $request->input('header_value5'),
            'header_value6' => $request->input('header_value6'),
        ]);

        $header = new header();
        foreach ($headerData as $key => $value) {
            $header->$key = json_encode($value);
        }
        $header->save();


        return redirect()->route('header.index');
    }

    public function edit($id)
    {
        $header = header::find($id);
        return view('header.edit', compact('header'));
    }

    public function update(Request $request, $id)
    {



        $validator = Validator::make($request->all(), [
            'header_value1' => 'nullable|array',
            'header_value2' => 'nullable|array',
            'header_value3' => 'nullable|array',
            'header_value4' => 'nullable|array',
            'header_value5' => 'nullable|array',
            'header_value6' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'حدث خطاء اثناء التسجيل: ' . $validator->errors());
        }


        $header = header::find($id);

        $headerData = array_filter([
            'header_value1' => $request->input('header_value1'),
            'header_value2' => $request->input('header_value2'),
            'header_value3' => $request->input('header_value3'),
            'header_value4' => $request->input('header_value4'),
            'header_value5' => $request->input('header_value5'),
            'header_value6' => $request->input('header_value6'),
        ]);

        $header->update([
            'header_value1' => json_encode($headerData['header_value1']),
            'header_value2' => json_encode($headerData['header_value2']),
            'header_value3' => json_encode($headerData['header_value3']),
            'header_value4' => json_encode($headerData['header_value4']),
            'header_value5' => json_encode($headerData['header_value5']),
            'header_value6' => json_encode($headerData['header_value6']),
        ]);
        $header->save();
        return redirect()->route('header.index');
    }

    public function destroy($id)
    {
        $header = header::find($id);
        $header->forceDelete();
        return redirect()->route('header.index');
    }
}
