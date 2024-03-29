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
                    <a href="{{ route('uservendor.create') }}" class="btn btn-primary btn-md">Add Vendor</a>
                    <h4>Vendors</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('uservendor.index') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                        placeholder="Search by Vendor Name or Phone" name="search"
                                        value="{{ $search ?? '' }}">
                                    <!-- Set the value of the search input field with the current search keyword -->
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table" id="save-stage" style="width:100%;">
                        <thead>
                            <tr class="bg-secondary">
                                <th class="border border-1">SN</th>
                                <th class="border border-1">Name</th>
                                <th class="border border-1">Email</th>
                                <th class="border border-1">Phone</th>
                                <th class="border border-1">Address</th>
                                <th class="border border-1">Coordinate</th>
                                <th class="border border-1">No. of Products</th>
                                <th class="border border-1">Created At</th>
                                <th class="border border-1">Updated At</th>
                                <th class="border border-1">Action</th>
                            </tr>
                        </thead>

                        <tbody style="font-size: 14px">
                            @foreach ($vendors as $index => $item)
                                <tr>
                                    <td class="border border-1">{{ ++$index }}</td>
                                    <td class="border border-1">{{ $item->name }}</td>
                                    <td class="border border-1">{{ $item->email }}</td>
                                    <td class="border border-1">{{ $item->phone }}</td>
                                    <td class="border border-1">{{ $item->common_address->name ?? 'N/A' }}</td>
                                    <td class="border border-1">{{ $item->coordinate ?? 'N/A' }}</td>
                                    <td class="border border-1">{{ $item->products->count() }}</td> <!-- Retrieve and display the number of products -->
                                    <td class="border border-1">{{ $item->created_at }}</td>
                                    <td class="border border-1">{{ $item->updated_at }}</td>
                                    <td class="border border-1">
                                        <form action="{{ route('uservendor.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')

                                            <div class="d-flex">
                                                <a href="{{ route('uservendor.edit', $item->id) }}"
                                                    class="btn btn-info btn-sm mr-2">Edit</a>

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger btn-sm mr-2" data-toggle="modal"
                                                    data-target="#deleteModal{{ $item->id }}">
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
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this vendor?</p>
                                                            <p><strong>User:</strong> {{ $item->name }}</p>
                                                            <p><strong>Email:</strong> {{ $item->email }}</p>
                                                            <p><strong>Phone:</strong> {{ $item->phone }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                data-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('uservendor.destroy', $item->id) }}"
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
