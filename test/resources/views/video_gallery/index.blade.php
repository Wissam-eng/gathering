@extends('layouts.app')

@section('content')
    {{-- @dd($main) --}}


    @if (session('success'))
        <div
            class="flex items-center p-3.5 rounded text-success bg-success-light dark:bg-success-dark-light text-align-center">
            {{ session('success') }}

        </div>
    @endif




    @if (session('error'))
        <div class="flex items-center p-3.5 rounded text-danger bg-danger-light dark:bg-danger-dark-light text-align-center">
            {{ session('error') }}

        </div>
    @endif



    <div class="card">

        @foreach ($video_gallerys as $item)
            <div style="display: flex; flex-direction: column;"
                class="max-w-[19rem] w-full bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none card">

                <div style="display: flex; justify-content: space-evenly;"
                    class="flex items-center justify-between py-4 px-6 border-b border-[#e0e6ed] dark:border-[#1b2e4b]">
                    <a href="{{ route('video_gallery.edit', $item->id) }}"
                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>

                    <form id="delete-form-{{ $item->id }}" action="{{ route('video_gallery.destroy', $item->id) }}"
                        method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                    <a href="javascript:void(0);" onclick="confirmDelete({{ $item->id }})"
                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-600">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </div>





                <div class="py-7 px-6">
                    {{-- <div class="-mt-7 mb-7 -mx-6 rounded-tl rounded-tr h-[215px] overflow-hidden">
                        <video src="{{ asset($item->video) }}" alt="video" class="w-full h-full object-cover"
                            controls></video>
                    </div> --}}





                    <div style="display: flex;border: 1px solid black;height: 99px;" class="-mt-7 mb-7 -mx-6 rounded-tl rounded-tr h-[215px] overflow-hidden" style="border: 1px solid black;">
                        <input type="text" name="title" value="{{ $item->title }}" placeholder="Some Text..." class="form-input" disabled />




                    </div>


                </div>

                <div>
                    <label for="ctnEmail">external_link_youtube</label>
                    <input type="text" name="external_link" value="{{ $item->external_link }}" placeholder="Some Text..." class="form-input" disabled />
                </div>
            </div>
        @endforeach

    </div>


    <style>
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
