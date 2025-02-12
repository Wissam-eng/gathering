@extends('layouts.app')

@section('content')
    <!-- start main content section -->
    <div x-data="sales">
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>newsletter</span>
            </li>
        </ul>

        <a href="{{ url('/export-newsletter') }}" class="btn btn-success">
            Export to Excel
        </a>

        <div class="pt-5">
            <div class="grid grid-cols-1 gap-6">
                <div class="panel h-full w-full">
                    <div class="mb-5 flex items-center justify-between">
                        <h5 class="text-lg font-semibold dark:text-white-light">newsletter</h5>
                    </div>
                    <div class="table-responsive">
                        <table id="newsletterTable" class="display">
                            <thead>
                                <tr>
                                    <th>email</th>
                                    <th>register at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($newsletters as $member)
                                    <tr>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ $member->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end main content section -->
@endsection
