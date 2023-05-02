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
                    <a href="{{ route('subcategory.create') }}" class="btn btn-primary btn-md">Add Sub Category</a>
                    <h6>Sub Categories</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('subcategory.index') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search by sub category name"
                                        name="search" value="{{ $search ?? '' }}">
                                    <!-- Set the value of the search input field with the current search keyword -->
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table">
                        <tr class="bg-secondary">
                            <th class="border border-1">SN</th>
                            <th class="border border-1">Sub Category</th>
                            <th class="border border-1">Image</th>
                            <th class="border border-1 w-50">Category</th>
                            {{-- <th class="border border-1 w-50">Slug</th> --}}
                            <th class="border border-1">Action</th>
                        </tr>

                        @foreach ($subcategories as $index => $item)
                            <tr>
                                <td class="border border-1">{{ ++$index }}</td>
                                <td class="border border-1">{{ $item->name }}</td>
                                <td class="border border-1">
                                    <!-- Displaying the image using the <img> tag -->
                                    <img src="{{ $item->image }}" alt="Category Image" width="50" height="50">
                                </td>
                                <td class="border border-1">{{ $item->category->name }}</td>
                                {{-- <td class="border border-1">{{ $item->slug }}</td> --}}
                                <td class="border border-1">
                                    <form action="{{ route('subcategory.destroy', $item->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <a href="{{ route('subcategory.edit', $item->id) }}"
                                            class="btn btn-info btn-sm">Edit</a>
                                        <!-- Add this code inside your index.blade.php file -->

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteModal{{ $item->id }}">
                                            Delete
                                        </button>

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
                                                        <p>Are you sure you want to delete this category?</p>
                                                        <p><strong>Sub Category:</strong> {{ $item->name }}</p>
                                                        <p><strong>Image:</strong> <img src="{{ $item->image }}"
                                                                alt="Category Image" width="50" height="50"></p>
                                                        <p><strong>Category:</strong> {{ $item->category->name }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('subcategory.destroy', $item->id) }}"
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
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
