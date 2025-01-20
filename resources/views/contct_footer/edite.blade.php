@extends('layouts.app')

@section('content')
    @if (session('error'))
        <div class="flex cards-center p-3.5 rounded text-danger bg-danger-light dark:bg-danger-dark-light text-align-center">
            {{ session('error') }}

        </div>
    @endif
    <div class="container" style="width: 50%;">


        <!-- card -->
        <div
            class="max-w-[19rem] w-full bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none card">



            <div class="py-7 px-6">



                <div>
                    <label for="ctnEmail">phone</label>
                    <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                        {{ $card->phone }}
                    </h2>
                </div>





                <hr>




                <div>
                    <label for="ctnEmail">whatsapp</label>
                    <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                        {{ $card->whatsapp }}
                    </h2>
                </div>



                <hr>
                <!-- العنوان الفرعي -->


                <div>
                    <label for="ctnEmail">location</label>
                    <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                        {{ $card->location }}
                    </h2>
                </div>





                <hr>
                <!-- العنوان الفرعي -->



                <div>
                    <label for="ctnEmail">email</label>
                    <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                        {{ $card->email }}
                    </h2>
                </div>


                <hr>
                <!-- العنوان الفرعي -->

                <div>
                    <label for="ctnEmail">website</label>
                    <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                        {{ $card->website }}
                    </h2>
                </div>




                <hr>
                <!-- العنوان الفرعي -->



                <div>
                    <label for="ctnEmail">facebook</label>
                    <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                        {{ $card->facebook }}
                    </h2>
                </div>


                <hr>
                <!-- العنوان الفرعي -->


                <div>
                    <label for="ctnEmail">instagram</label>
                    <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                        {{ $card->instagram }}
                    </h2>
                </div>


                <hr>
                <!-- العنوان الفرعي -->



                <div>
                    <label for="ctnEmail">twitter</label>
                    <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                        {{ $card->twitter }}
                    </h2>
                </div>
                <hr>



            </div>
        </div>

        <!-- form controls -->
        <form class="space-y-5" method="POST" action="{{ route('contct_footer.update', $card) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div id="contact-fields">

                <div class="contact-field">
                    <input type="text" name="phone" value="{{ $card->phone }}" placeholder="phone "
                        class="form-input">
                    <input type="text" name="whatsapp" value="{{ $card->whatsapp }}" placeholder="whatsapp"
                        class="form-input">
                    <input type="text" name="location" value="{{ $card->location }}" placeholder="address"
                        class="form-input">
                    <input type="email" name="email" value="{{ $card->email }}" placeholder="email"
                        class="form-input">
                    <input type="url" name="website" value="{{ $card->website }}" placeholder="website"
                        class="form-input">
                    <input type="url" name="facebook" value="{{ $card->facebook }}" placeholder="facebook"
                        class="form-input">
                    <input type="url" name="instagram" value="{{ $card->instagram }}" placeholder="instagram"
                        class="form-input">
                    <input type="url" name="twitter" value="{{ $card->twitter }}" placeholder="twitter"
                        class="form-input">
                </div>
            </div>
            <button type="submit" class="btn btn-primary !mt-6">update</button>
        </form>
    </div>
@endsection
