@extends('layouts.app')

@section('content')


@if (session('error'))
<div class="flex items-center p-3.5 rounded text-danger bg-danger-light dark:bg-danger-dark-light text-align-center">
    {{ session('error') }}

</div>
@endif


    <div class="container" style="width: 50%;">

        <!-- form controls -->
        <form class="space-y-5" method="POST" action="{{ route('key_speakers.store') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div>
                <label for="ctnEmail">name</label>
                <input type="text" name="name" placeholder="Some one..." class="form-input" required />
            </div>

            <div>
                <label for="ctnEmail">Title</label>
                <input type="text" name="title" placeholder="Some Text..." class="form-input" required />
            </div>





            <div>
                <label for="ctnTextarea">Description</label>
                <textarea id="ctnTextarea" rows="3" name="description" class="form-textarea" placeholder="Description" ></textarea>
            </div>
            <div>
                <label for="ctnFile">Upload Imag</label>
                <input id="ctnFile" type="file" name="image"
                    class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary"
                    required />
            </div>


            <div>
                <label for="ctnFile">Upload file</label>
                <input id="ctnFile" type="file" name="file"
                    class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary"
                     />
            </div>
            <button type="submit" class="btn btn-primary !mt-6">Submit</button>
        </form>
    </div>
@endsection
