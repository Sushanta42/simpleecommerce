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
                    <a href="{{ route('commonaddress.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h6>Edit Common-Address</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('commonaddress.update', $commonaddress->id) }}" method="post",
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name">Address Name</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $commonaddress->name }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <br />

                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                            data-target="#editModal">Update Record</button>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                            aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit CommonAddress</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your modal body content here -->
                                        <p>Are you sure you want to update this commonaddress?</p>
                                        <p><strong>Old commonaddress:</strong> {{ $commonaddress->name }}</p>
                                        <p><strong>Updated commonaddress:</strong> <span id="updatedCategoryName"></span></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Update the modal body with the updated category name
        document.getElementById('name').addEventListener('input', function() {
            document.getElementById('updatedCategoryName').textContent = this.value;
        });
    </script>
</x-admin-layout>
