@extends('layouts.app')

@section('content')
    @if (session('error'))
        <div class="flex items-center p-3.5 rounded text-danger bg-danger-light dark:bg-danger-dark-light text-align-center">
            {{ session('error') }}

        </div>
    @endif
    <div class="container" style="width: 50%;">


        <!-- card -->
        <div
            class="max-w-[19rem] w-full bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none card">



            <div class="py-7 px-6">
                <!-- صورة الكارت -->
                <div class="-mt-7 mb-7 -mx-6 rounded-tl rounded-tr h-[215px] overflow-hidden">
                    <img src="{{ asset($card->image) }}" alt="image" class="w-full h-full object-cover" />
                </div>



            </div>
        </div>

        <!-- form controls -->
        <form class="space-y-5" method="POST" action="{{ route('partners.update', $card) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <div>
                <label for="ctnFile">Upload Imag</label>
                <input id="ctnFile" type="file" name="images"
                    class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary" />
            </div>
            <button type="submit" class="btn btn-primary !mt-6">update</button>
        </form>
    </div>
@endsection
