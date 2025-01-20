@extends('layouts.app')

@section('content')
    @if (session('error'))
        <div class="flex items-center p-3.5 rounded text-danger bg-danger-light dark:bg-danger-dark-light text-align-center">
            {{ session('error') }}

        </div>
    @endif


    <div class="container" style="width: 50%;">

        <!-- form controls -->
        <form class="space-y-5" method="POST" action="{{ route('contct_footer.store') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="py-7 px-6">
                <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">

                </h2>

                <hr>

                <h5 class="text-[#3b3f5c] text-lg font-semibold mb-4 dark:text-white-light fixed-height-subtitle">

                </h5>
                <hr>

                <h5 class="text-[#3b3f5c] text-lg font-semibold mb-4 dark:text-white-light fixed-height-subtitle">
                    contact footer
                </h5>

                <div id="contact-fields">
                    <div class="contact-field">
                        <input type="text" name="phone" placeholder="phone " class="form-input">
                        <input type="text" name="whatsapp" placeholder="whatsapp" class="form-input">
                        <input type="text" name="location" placeholder="address" class="form-input">
                        <input type="email" name="email" placeholder="email" class="form-input">
                        <input type="url" name="website" placeholder="website" class="form-input">
                        <input type="url" name="facebook" placeholder="facebook" class="form-input">
                        <input type="url" name="instagram" placeholder="instagram" class="form-input">
                        <input type="url" name="twitter" placeholder="twitter" class="form-input">
                    </div>
                </div>

                <hr>



            </div>





            <button type="submit" class="btn btn-primary !mt-6">Submit</button>
        </form>
    </div>
@endsection
