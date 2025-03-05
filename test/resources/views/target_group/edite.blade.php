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



                <!-- العنوان -->
                <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                    {{ $card->title }}
                </h2>

                <hr>

            </div>
        </div>

        <!-- form controls -->
        <form class="space-y-5" method="POST" action="{{ route('target_group.update', $card) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="ctnEmail">Title</label>
                <input type="text" name="title" value="{{ $card->title }}" placeholder="Some Text..."
                    class="form-input" required />
            </div>


            <button type="submit" class="btn btn-primary !mt-6">update</button>
        </form>
    </div>
@endsection
