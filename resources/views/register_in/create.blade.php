@extends('layouts.app')

@section('content')
    <div class="container" style="width: 50%;">

        <!-- form controls -->
        <form class="space-y-5" method="POST" action="{{ route('main.store') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div>
                <label for="ctnEmail">Title</label>
                <input type="text" name="title" placeholder="Some Text..." class="form-input" required />
            </div>

            <div>
                <label for="ctnEmail">Address</label>
                <input type="text" name="address" placeholder="Some Text..." class="form-input" required />
            </div>



            <!-- basic -->
            <div x-data="form">
                <input id="basic" type="text" x-model="date1" class="form-input" />
            </div>




            <div>
                <label for="ctnTextarea">Description</label>
                <textarea id="ctnTextarea" rows="3" name="description" class="form-textarea" placeholder="Description" required></textarea>
            </div>
            <div>
                <label for="ctnFile">Upload Imag</label>
                <input id="ctnFile" type="file" name="image"
                    class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary"
                    required />
            </div>
            <button type="submit" class="btn btn-primary !mt-6">Submit</button>
        </form>
    </div>
@endsection
