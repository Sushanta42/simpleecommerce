@php
    $statusColors = [
        'on_review' => 'light',
        'completed' => 'success',
        'cancelled' => 'warning',
    ];
    $vehicleColors = [
        '2_wheeler' => 'info',
        '4_wheeler' => 'success',
        'others' => 'light',
    ];
    $billbookColors = [
        'active' => 'light',
        'notice_time' => 'info',
        'expiry' => 'danger',
    ];
@endphp
<x-admin-layout>
    <section>
        <div class="container">
            @if (Session::has('success') || Session::has('error'))
                <div class="alert alert-{{ Session::has('success') ? 'success' : 'danger' }} alert-dismissible fade show"
                    role="alert">
                    {{ Session::has('success') ? Session::get('success') : Session::get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        $('.alert').alert('close');
                    }, 3000); // Close the alert after 3 seconds (3000 milliseconds)
                </script>
            @endif
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('billbook.create') }}" class="btn btn-primary btn-md">Add User BlueBook</a>
                    <h6>Bluebook Details</h6>
                </div>
                <div class="card-body">
                    <table class="table" id="save-stage" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="border border-1">SN</th>
                                <th class="border border-1">User Name</th>
                                <th class="border border-1">Phone</th>
                                <th class="border border-1">Municipality</th>
                                <th class="border border-1">Address</th>
                                <th class="border border-1">Cover Image</th>
                                <th class="border border-1">Image</th>
                                <th class="border border-1">Vehicle Type</th>
                                <th class="border border-1">Status</th>
                                <th class="border border-1">Renewal Date</th>
                                <th class="border border-1">BlueBook Status</th>
                                <th class="border border-1">Action</th>
                            </tr>
                        </thead>

                        <tbody style="font-size: 14px">
                            @foreach ($billbooks as $index => $item)
                                <tr>
                                    <td class="border border-1">{{ ++$index }}</td>
                                    <td class="border border-1">{{ $item->name }}</td>
                                    <td class="border border-1">{{ $item->phone }}</td>
                                    {{-- <td class="border border-1">
                                        <!-- Displaying the image using the <img> tag -->
                                        <img src="{{ $item->image }}" alt="Category Image" width="50"
                                            height="50">
                                    </td> --}}
                                    <td class="border border-1">{{ $item->municipality }}</td>
                                    <td class="border border-1">{{ $item->address }}</td>
                                    <td class="border border-1">
                                        <a href="" data-toggle="modal"
                                            data-target="#basicModal{{ $item->id }}"> <img
                                                src="{{ asset($item->image_front) }}" width="60" alt=""></a>
                                        <div class="modal fade" id="basicModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div>
                                                        <img src="{{ asset($item->image_front) }}" class="img-fluid"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border border-1">
                                        <a href="" data-toggle="modal"
                                            data-target="#roadModal{{ $item->id }}"> <img
                                                src="{{ asset($item->image) }}" width="60" alt=""></a>
                                        <div class="modal fade" id="roadModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="roadImageLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div>
                                                        <img src="{{ asset($item->image) }}" class="img-fluid"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border border-1">
                                        <span
                                            class="badge badge-{{ $vehicleColors[$item->vehicle_type] }}">{{ $item->vehicle_type }}</span>
                                    </td>
                                    <td class="border border-1">
                                        <span
                                            class="badge badge-{{ $statusColors[$item->status] }}">{{ $item->status }}</span>
                                    </td>
                                    <td class="border border-1">{{ $item->renewal_date ?? 'null' }}</td>
                                    <td class="border border-1">
                                        <span
                                            class="badge badge-{{ $billbookColors[$item->billbook_status] ?? 'light' }}">{{ $item->billbook_status ?? 'null' }}</span>
                                    </td>
                                    <td class="border border-1">
                                        <form action="{{ route('billbook.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <div class="d-flex">
                                                <a href="{{ route('billbook.show', $item->id) }}"
                                                    class="btn btn-warning btn-sm mr-2">View</a>

                                                <a href="{{ route('billbook.edit', $item->id) }}"
                                                    class="btn btn-info btn-sm mr-2">Edit</a>
                                                <!-- Add this code inside your index.blade.php file -->

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger btn-sm mr-2"
                                                    data-toggle="modal" data-target="#deleteModal{{ $item->id }}">
                                                    Delete
                                                </button>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="deleteModalLabel{{ $item->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="deleteModalLabel{{ $item->id }}">Delete
                                                                Confirmation</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        {{-- <div class="modal-body">
                                                            <p>Are you sure you want to delete this category?</p>
                                                            <p><strong>Sub Category:</strong> {{ $item->name }}</p>
                                                            <p><strong>Image:</strong> <img src="{{ $item->image }}"
                                                                    alt="Category Image" width="50" height="50">
                                                            </p>
                                                            <p><strong>Category:</strong> {{ $item->category->name }}
                                                            </p>
                                                        </div> --}}
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                data-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('billbook.destroy', $item->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
