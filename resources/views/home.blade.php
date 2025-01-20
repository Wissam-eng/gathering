@extends('layouts.app')

@section('content')
    {{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> --}}



    <!-- start main content section -->
    <div x-data="sales">
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Members</span>
            </li>
        </ul>

        <div class="pt-5">


            <div class="grid grid-cols-1 gap-6 ">
                <div class="panel h-full w-full">
                    <div class="mb-5 flex items-center justify-between">
                        <h5 class="text-lg font-semibold dark:text-white-light">Members</h5>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th class="ltr:rounded-l-md rtl:rounded-r-md">name</th>
                                    <th>Job title</th>
                                    <th>company</th>
                                    <th class="ltr:rounded-r-md rtl:rounded-l-md">Membership</th>
                                    <th>email</th>
                                    <th>phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="group text-white-dark hover:text-black dark:hover:text-white-light/90">
                                    <td class="min-w-[150px] text-black dark:text-white">
                                        <div class="flex items-center">

                                            <span class="whitespace-nowrap">Luke Ivory</span>
                                        </div>
                                    </td>
                                    <td class="text-primary">Headphone</td>
                                    <td><a href="apps-invoice-preview.html">#46894</a></td>
                                    <td>$56.07</td>
                                    <td><span class="badge bg-success shadow-md dark:group-hover:bg-transparent">Paid</span>
                                    </td>
                                </tr>
                                <tr class="group text-white-dark hover:text-black dark:hover:text-white-light/90">
                                    <td class="text-black dark:text-white">
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3"
                                                src="{{ url('resources/views/home/assets/images/profile-7.jpeg') }}"
                                                alt="avatar" />
                                            <span class="whitespace-nowrap">Andy King</span>
                                        </div>
                                    </td>
                                    <td class="text-info">Nike Sport</td>
                                    <td><a href="apps-invoice-preview.html">#76894</a></td>
                                    <td>$126.04</td>
                                    <td><span
                                            class="badge bg-secondary shadow-md dark:group-hover:bg-transparent">Shipped</span>
                                    </td>
                                </tr>
                                <tr class="group text-white-dark hover:text-black dark:hover:text-white-light/90">
                                    <td class="text-black dark:text-white">
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3"
                                                src="{{ url('resources/views/home/assets/images/profile-8.jpeg') }}"
                                                alt="avatar" />
                                            <span class="whitespace-nowrap">Laurie Fox</span>
                                        </div>
                                    </td>
                                    <td class="text-warning">Sunglasses</td>
                                    <td><a href="apps-invoice-preview.html">#66894</a></td>
                                    <td>$56.07</td>
                                    <td><span class="badge bg-success shadow-md dark:group-hover:bg-transparent">Paid</span>
                                    </td>
                                </tr>
                                <tr class="group text-white-dark hover:text-black dark:hover:text-white-light/90">
                                    <td class="text-black dark:text-white">
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3"
                                                src="{{ url('resources/views/home/assets/images/profile-9.jpeg') }}"
                                                alt="avatar" />
                                            <span class="whitespace-nowrap">Ryan Collins</span>
                                        </div>
                                    </td>
                                    <td class="text-danger">Sport</td>
                                    <td><a href="apps-invoice-preview.html">#75844</a></td>
                                    <td>$110.00</td>
                                    <td><span
                                            class="badge bg-secondary shadow-md dark:group-hover:bg-transparent">Shipped</span>
                                    </td>
                                </tr>
                                <tr class="group text-white-dark hover:text-black dark:hover:text-white-light/90">
                                    <td class="text-black dark:text-white">
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3"
                                                src="{{ url('resources/views/home/assets/images/profile-10.jpeg') }}"
                                                alt="avatar" />
                                            <span class="whitespace-nowrap">Irene Collins</span>
                                        </div>
                                    </td>
                                    <td class="text-secondary">Speakers</td>
                                    <td><a href="apps-invoice-preview.html">#46894</a></td>
                                    <td>$56.07</td>
                                    <td><span class="badge bg-success shadow-md dark:group-hover:bg-transparent">Paid</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- end main content section -->
@endsection
