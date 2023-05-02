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
                    <a href="{{ route('commonaddress.create') }}" class="btn btn-primary btn-md">Add Common Address</a>
                    <h5>Common Addresses</h5>
                </div>
                <div class="card-body">
                    <table class="table" id="save-stage" style="width:100%;">
                        <thead>
                            <tr class="bg-secondary">
                                <th class="border border-1">SN</th>
                                <th class="border border-1">Name</th>
                                <th class="border border-1">Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 14px">
                            @foreach ($commonaddresses as $index => $item)
                                <tr>
                                    <td class="border border-1">{{ ++$index }}</td>
                                    <td class="border border-1">{{ $item->name }}</td>
                                    <td class="border border-1">
                                        <form action="{{ route('commonaddress.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="{{ route('commonaddress.edit', $item->id) }}"
                                                class="btn btn-primary btn-md">Edit</a>
                                            <!-- Add this code inside your index.blade.php file -->

                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger btn-md" data-toggle="modal"
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
                                                            <p>Are you sure you want to delete this Address?</p>
                                                            <p><strong>Address:</strong> {{ $item->name }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                data-dismiss="modal">Cancel</button>
                                                            <form
                                                                action="{{ route('commonaddress.destroy', $item->id) }}"
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
