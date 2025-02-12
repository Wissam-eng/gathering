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
            <div>
                <label for="ctnEmail">Title</label>
                <input type="text" value="{{ $card['title'] }}" placeholder="Some Text..." class="form-input" disabled />
            </div>



            @if ($card)
                <h2>Cover:</h2>
                <img src="{{ asset($card['cover']) }}" alt="Cover Image" style="width: 100%; max-width: 300px;">
                <h2>Images:</h2>
                <div style="display: flex; gap: 10px;">
                    @foreach ($card['images'] as $image)
                        <img src="{{ asset($image) }}" alt="Image"
                            style="width: 100px; height: 100px; object-fit: cover;">
                    @endforeach
                </div>
            @endif



        </div>



        <!-- form controls -->
        <form class="space-y-5" method="POST" action="{{ route('photo_gallery.update', $card['code']) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <div>
                <label for="ctnEmail">Title</label>
                <input type="text" name="title" placeholder="Some Text..." class="form-input" />
            </div>


            <div>
                <label for="ctnFile">Upload cover</label>
                <input id="ctnFile" type="file" name="cover" class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary" />
            </div>



            <div>
                <label for="ctnFile">Upload Images</label>
                <input id="ctnFile" type="file" name="images[]"
                    class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary"
                    multiple />
            </div>


            <button type="submit" class="btn btn-primary !mt-6">Submit</button>
        </form>
    </div>
@endsection
