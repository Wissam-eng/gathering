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



    <div class="card-container" style="display: flex; flex-wrap: wrap; gap: 20px;">
        @foreach ($photoGalleries as $gallery)
            <!-- بطاقة لكل مجموعة -->
            <div class="card"
                style="width: 100%; max-width: 300px; border: 1px solid #e0e6ed; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                <!-- غلاف الصورة الرئيسي -->
                <div class="cover" style="height: 200px; overflow: hidden;">
                    <img src="{{ asset($gallery['cover']) }}" alt="Cover Image"
                        style="width: 100%; height: 100%; object-fit: cover;">
                </div>

                <!-- شريط الصور المصغرة -->
                <div class="thumbnails" style="padding: 10px; display: flex; gap: 5px; overflow-x: auto;">
                    @foreach ($gallery['images'] as $image)
                        <div class="thumbnail"
                            style="flex: 0 0 auto; width: 60px; height: 60px; border: 1px solid #e0e6ed; border-radius: 4px; overflow: hidden;">
                            <img src="{{ asset($image) }}" alt="Thumbnail"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @endforeach
                </div>

                <!-- زر التعديل والحذف -->
                <div class="actions" style="padding: 10px; display: flex; justify-content: space-between;">
                    <a href="{{ route('photo_gallery.edit', $gallery['code']) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>

                    <a href="javascript:void(0);" onclick="confirmDelete('{{ $gallery['code'] }}')"

                        class="text-red-600 hover:text-red-800">
                        <i class="fa-solid fa-trash"></i>
                    </a>

                    <form id="delete-form-{{ $gallery['code'] }}"
                        action="{{ route('photo_gallery.destroy', $gallery['code']) }}" method="POST"
                        style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>


                </div>
            </div>
        @endforeach
    </div>



    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card .thumbnails {
            display: flex;
            gap: 5px;
            overflow-x: auto;
            padding-bottom: 10px;
        }

        .card .thumbnails::-webkit-scrollbar {
            height: 5px;
        }

        .card .thumbnails::-webkit-scrollbar-thumb {
            background: #cccccc;
            border-radius: 5px;
        }

        .card .thumbnails .thumbnail img {
            transition: transform 0.2s ease-in-out;
        }

        .card .thumbnails .thumbnail img:hover {
            transform: scale(1.1);
        }
    </style>
@endsection
