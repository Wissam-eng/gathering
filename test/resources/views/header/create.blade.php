@extends('layouts.app')

@section('content')
    @if (session('error'))
        <div class="flex items-center p-3.5 rounded text-danger bg-danger-light dark:bg-danger-dark-light text-align-center">
            {{ session('error') }}
        </div>
    @endif

    <div class="container" style="width: 50%;">
        <!-- form controls -->
        <form class="space-y-5" method="POST" action="{{ route('header.store') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

            @for ($i = 1; $i <= 6; $i++)
                <div>
                    <label for="header_value{{ $i }}">Header Value {{ $i }} (Number)</label>
                    <input type="text" name="header_value{{ $i }}[]" placeholder="Enter a number" class="form-input" required />
                </div>
                <div>
                    <label for="header_value{{ $i }}">Header Value {{ $i }} (Text)</label>
                    <input type="text" name="header_value{{ $i }}[]" placeholder="Enter text" class="form-input" required />
                </div>
            @endfor

            <button type="submit" class="btn btn-primary !mt-6">Submit</button>
        </form>
    </div>
@endsection
