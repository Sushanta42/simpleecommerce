<x-vendor-layout>
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
                    }, 8000); // Close the alert after 3 seconds (3000 milliseconds)
                </script>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('product.create') }}" class="btn btn-primary btn-md">Add Product</a>
                    <h4>Products</h4>
                </div>
                <div class="card-body">
                    <table class="table" id="save-stage" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="border border-1">SN</th>
                                <th class="border border-1">Image</th>
                                <th class="border border-1">Name</th>
                                <th class="border border-1">Category</th>
                                <th class="border border-1">Sub Category</th>
                                <th class="border border-1">Price (Rs.)</th>
                                <th class="border border-1">Selling Price (Rs.)</th>
                                <th class="border border-1">Availability</th>
                                <th class="border border-1">Created At</th>
                                <th class="border border-1">Updated At</th>
                                <th class="border border-1">Action</th>
                            </tr>
                        </thead>

                        <tbody style="font-size: 14px">
                            @foreach ($products as $index => $item)
                                <tr class="border border-1">
                                    <td class="border border-1">{{ ++$index }}</td>
                                    <td class="border border-1">
                                        <a href="" data-toggle="modal"
                                            data-target="#basicModal{{ $item->id }}"> <img
                                                src="{{ asset($item->image) }}" width="60" alt=""></a>
                                        <div class="modal fade" id="basicModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <td class="border border-1">{{ $item->name }}</td>
                                    <td class="border border-1"><span
                                            class="badge badge-light">{{ $item->category->name}}</span>
                                    </td>
                                    <td class="border border-1"><span
                                            class="badge badge-light">{{ $item->sub_category->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="border border-1">{{ $item->price }}</td>
                                    <td class="border border-1">{{ $item->sale_price }}</td>
                                    <td class="border border-1">{{ $item->availability }}</td>
                                    <td class="border border-1">{{ $item->created_at }}</td>
                                    <td class="border border-1">{{ $item->updated_at }}</td>
                                    <td class="border border-1">
                                        <form action="{{ route('product.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')

                                            <div class="d-flex">
                                                <a href="{{ route('product.show', $item->id) }}"
                                                    class="btn btn-info btn-sm mr-2">View</a>

                                                <a href="{{ route('product.edit', $item->id) }}"
                                                    class="btn btn-primary btn-sm mr-2">Edit</a>

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
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this product?</p>
                                                            <p><strong>Product Name:</strong> {{ $item->name }}</p>
                                                            <p><strong> Category: </strong>
                                                                {{ $item->category->name }}</p>
                                                            <p><strong>Image:</strong> <img
                                                                    src="{{ asset($item->image) }}" class="img-fluid"
                                                                    alt="SubCategoryimg" height="70", width="70">
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                data-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('product.destroy', $item->id) }}"
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
                    {{-- {{ $users->links('pagination::bootstrap-5') }} --}}
                </div>
            </div>
        </div>
    </section>
</x-vendor-layout>
