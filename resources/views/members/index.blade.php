@extends('layouts.app')

@section('content')
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

        <a href="{{ url('/export-members') }}" class="btn btn-success">
            Export to Excel
        </a>
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
                                    <th>city</th>
                                    <th>register at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr class="group text-white-dark hover:text-black dark:hover:text-white-light/90">
                                        <td class="min-w-[150px] text-black dark:text-white">
                                            <div class="flex items-center">
                                                <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3"
                                                    src="{{ $member->image ? asset($member->image) : url('resources/views/main/assets/images/user-profile.jpeg') }}"
                                                    alt="avatar" />
                                                <span
                                                    class="whitespace-nowrap">{{ $member->first_name . ' ' . $member->last_name }}</span>
                                            </div>
                                        </td>
                                        <td><span
                                                class="badge bg-success shadow-md dark:group-hover:bg-transparent">{{ $member->job_title }}</span>
                                        </td>
                                        <td><span
                                                class="badge bg-success shadow-md dark:group-hover:bg-transparent">{{ $member->company }}</span>
                                        </td>
                                        <td><span
                                                class="badge bg-success shadow-md dark:group-hover:bg-transparent">{{ $member->register_as }}</span>
                                        </td>
                                        <td><span
                                                class="badge bg-success shadow-md dark:group-hover:bg-transparent">{{ $member->email }}</span>
                                        </td>

                                        <td><span
                                                class="badge bg-success shadow-md dark:group-hover:bg-transparent">{{ $member->phone }}</span>
                                        </td>
                                        <td><span
                                                class="badge bg-success shadow-md dark:group-hover:bg-transparent">{{ $member->city }}</span>
                                        </td>
                                        <td><span
                                                class="badge bg-success shadow-md dark:group-hover:bg-transparent">{{ $member->created_at }}</span>
                                        </td>
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
