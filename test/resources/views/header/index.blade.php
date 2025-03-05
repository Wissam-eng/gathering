@extends('layouts.app')

@section('content')
    <!-- start main content section -->
    <div x-data="sales">
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">header</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Members</span>
            </li>
        </ul>

        <div class="pt-5">
            <div class="grid grid-cols-1 gap-6">
                <div class="panel h-full w-full">
                    <div class="mb-5 flex items-center justify-between">
                        <h5 class="text-lg font-semibold dark:text-white-light">header</h5>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>header_value1 (Number)</th>
                                    <th>header_value1 (Text)</th>
                                    <th>header_value2 (Number)</th>
                                    <th>header_value2 (Text)</th>
                                    <th>header_value3 (Number)</th>
                                    <th>header_value3 (Text)</th>
                                    <th>header_value4 (Number)</th>
                                    <th>header_value4 (Text)</th>
                                    <th>header_value5 (Number)</th>
                                    <th>header_value5 (Text)</th>
                                    <th>header_value6 (Number)</th>
                                    <th>header_value6 (Text)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($header as $member)
                                    @php
                                        $value1 = json_decode($member->header_value1);
                                        $value2 = json_decode($member->header_value2);
                                        $value3 = json_decode($member->header_value3);
                                        $value4 = json_decode($member->header_value4);
                                        $value5 = json_decode($member->header_value5);
                                        $value6 = json_decode($member->header_value6);
                                    @endphp
                                    <tr class="group text-white-dark hover:text-black dark:hover:text-white-light/90">
                                        <td><span class="badge bg-success">{{ $value1[0] ?? 'N/A' }}</span></td>
                                        <td><span class="badge bg-success">{{ $value1[1] ?? 'N/A' }}</span></td>
                                        <td><span class="badge bg-success">{{ $value2[0] ?? 'N/A' }}</span></td>
                                        <td><span class="badge bg-success">{{ $value2[1] ?? 'N/A' }}</span></td>
                                        <td><span class="badge bg-success">{{ $value3[0] ?? 'N/A' }}</span></td>
                                        <td><span class="badge bg-success">{{ $value3[1] ?? 'N/A' }}</span></td>
                                        <td><span class="badge bg-success">{{ $value4[0] ?? 'N/A' }}</span></td>
                                        <td><span class="badge bg-success">{{ $value4[1] ?? 'N/A' }}</span></td>
                                        <td><span class="badge bg-success">{{ $value5[0] ?? 'N/A' }}</span></td>
                                        <td><span class="badge bg-success">{{ $value5[1] ?? 'N/A' }}</span></td>
                                        <td><span class="badge bg-success">{{ $value6[0] ?? 'N/A' }}</span></td>
                                        <td><span class="badge bg-success">{{ $value6[1] ?? 'N/A' }}</span></td>
                                        <td>
                                            <a href="{{ route('header.edit', $member->id) }}" class="badge bg-warning shadow-md hover:bg-warning-dark">edit</a>
                                            <form id="delete-form-{{ $member->id }}" action="{{ route('header.destroy', $member->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <button onclick="confirmDelete({{ $member->id }})" class="badge bg-danger shadow-md hover:bg-danger-dark">
                                                Delete
                                            </button>
                                        </td>


                                        <script>
                                            function confirmDelete(id) {
                                                Swal.fire({
                                                    title: 'Are you sure?',
                                                    text: 'You won\'t be able to revert this!',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#d33',
                                                    cancelButtonColor: '#3085d6',
                                                    confirmButtonText: 'Yes, delete it!'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById(`delete-form-${id}`).submit();
                                                    }
                                                });
                                            }
                                        </script>

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
