@extends('layouts.app')

@section('content')
    {{-- @dd($main) --}}


    @if (session('message'))
        <div
            class="flex items-center p-3.5 rounded text-success bg-success-light dark:bg-success-dark-light text-align-center">
            {{ session('message') }}

        </div>
    @endif




    @if (session('error'))
        <div class="flex items-center p-3.5 rounded text-danger bg-danger-light dark:bg-danger-dark-light text-align-center">
            {{ session('error') }}

        </div>
    @endif



    <div class="card">

        @foreach ($contct_footers as $item)
            <!-- card -->
            <div style="display: flex; flex-direction: column;"
                class="max-w-[19rem] w-full bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none card">

                <!-- Header -->
                <div style="    display: flex;     justify-content: space-evenly;"
                    class="flex items-center justify-between py-4 px-6 border-b border-[#e0e6ed] dark:border-[#1b2e4b]">


                    <!-- زر التعديل -->
                    <a href="{{ route('contct_footer.edit', $item->id) }}"
                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>


                    <form id="delete-form-{{ $item->id }}" action="{{ route('contct_footer.destroy', $item->id) }}"
                        method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <!-- زر الحذف -->
                    <a href="javascript:void(0);" onclick="confirmDelete({{ $item->id }})"
                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-600">
                        <i class="fa-solid fa-trash"></i>
                    </a>


                </div>

                <div class="py-7 px-6" style="width: 100%;">



                    <div>
                        <label for="ctnEmail">phone</label>
                        <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                            {{ $item->phone }}
                        </h2>
                    </div>





                    <hr>




                    <div>
                        <label for="ctnEmail">whatsapp</label>
                        <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                            {{ $item->whatsapp }}
                        </h2>
                    </div>



                    <hr>
                    <!-- العنوان الفرعي -->


                    <div>
                        <label for="ctnEmail">location</label>
                        <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                            {{ $item->location }}
                        </h2>
                    </div>





                    <hr>
                    <!-- العنوان الفرعي -->



                    <div>
                        <label for="ctnEmail">email</label>
                        <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                            {{ $item->email }}
                        </h2>
                    </div>


                    <hr>
                    <!-- العنوان الفرعي -->

                    <div>
                        <label for="ctnEmail">website</label>
                        <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                            {{ $item->website }}
                        </h2>
                    </div>




                    <hr>
                    <!-- العنوان الفرعي -->



                    <div>
                        <label for="ctnEmail">facebook</label>
                        <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                            {{ $item->facebook }}
                        </h2>
                    </div>


                    <hr>
                    <!-- العنوان الفرعي -->


                    <div>
                        <label for="ctnEmail">instagram</label>
                        <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                            {{ $item->instagram }}
                        </h2>
                    </div>


                    <hr>
                    <!-- العنوان الفرعي -->



                    <div>
                        <label for="ctnEmail">twitter</label>
                        <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                            {{ $item->twitter }}
                        </h2>
                    </div>
                    <hr>


                    <div>
                        <label for="ctnEmail">Newsletter</label>
                        <h2 class="text-[#3b3f5c] text-lg font-semibold dark:text-white-light">
                            {{ $item->Newsletter }}
                        </h2>
                    </div>
                    <hr>



                </div>
            </div>
        @endforeach
    </div>


    <style>
    h2{
        overflow:auto;
    }
        .card {
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            justify-content: center;
            gap: 1%;
        }

        textarea {
            border: black 1px solid;
            resize: auto !important;
        }



        .fixed-height-title {
            height: 50px;
            /* الطول الثابت للعناوين */
            line-height: 1.5;
            overflow: hidden;
            /* لإخفاء النصوص الزائدة */
            text-overflow: ellipsis;
            /* لإضافة (...) في نهاية النص إذا تجاوز الطول */
            white-space: nowrap;
            /* يمنع التفاف النص */
        }

        .fixed-height-subtitle {
            height: 40px;
            /* الطول الثابت للعناوين الفرعية */
            line-height: 1.5;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .fixed-height-textarea {
            height: 80px;
            /* الطول الثابت للنصوص الطويلة */
            overflow-y: auto;
            /* يضيف شريط تمرير إذا تجاوز النص الطول */
            resize: none;
            /* يمنع المستخدم من تغيير الحجم يدويًا */
        }

        .fixed-height-paragraph {
            height: 60px;
            /* الطول الثابت للنصوص */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endsection
