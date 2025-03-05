@extends('layouts.app')

@section('content')
    @if (session('error'))
        <div class="flex items-center p-3.5 rounded text-danger bg-danger-light dark:bg-danger-dark-light text-align-center">
            {{ session('error') }}
        </div>
    @endif

    <div class="container" style="width: 50%;">
        <!-- form controls -->
        <form class="space-y-5" method="POST" action="{{ route('header.update', $header->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @for ($i = 1; $i <= 6; $i++)
                @php
                    $values = json_decode($header->{'header_value' . $i}, true) ?? [];
                    $number = $values[0] ?? '';  // القيمة الرقمية
                    $text = $values[1] ?? '';    // القيمة النصية
                @endphp

                <div>
                    <label for="header_value{{ $i }}_number">Header Value {{ $i }} (Number)</label>
                    <input type="text" name="header_value{{ $i }}[]" value="{{ $number }}" placeholder="Enter a number"
                        class="form-input" required />
                </div>
                <div>
                    <label for="header_value{{ $i }}_text">Header Value {{ $i }} (Text)</label>
                    <input type="text" name="header_value{{ $i }}[]" value="{{ $text }}" placeholder="Enter text"
                        class="form-input" required />
                </div>
            @endfor

            <button type="submit" class="btn btn-primary !mt-6">Update</button>
        </form>
    </div>
@endsection
