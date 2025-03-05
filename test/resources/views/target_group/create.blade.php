@extends('layouts.app')

@section('content')
    <div class="container" style="width: 50%;">

        <!-- form controls -->
        <form class="space-y-5" method="POST" action="{{ route('target_group.store') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div>
                <label for="ctnEmail">Title</label>
                <input type="text" name="title" placeholder="Some Text..." class="form-input" required />
            </div>


            <button type="submit" class="btn btn-primary !mt-6">Submit</button>
        </form>
    </div>
@endsection
