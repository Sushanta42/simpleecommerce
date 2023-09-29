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
                    <a href="{{ route('userfamily.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h4>Edit User Family Details</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('userfamily.update', $userfamily->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="user_id">User Number</label>
                            <select id="user_id" class="form-control" name="user_id">
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($userfamily->user_id == $item->id) selected @endif>{{ $item->phone }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $userfamily->name }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input id="mobile" class="form-control" type="number" name="mobile"
                                value="{{ $userfamily->mobile }}">
                            @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone (Optional)</label>
                            <input id="phone" class="form-control" type="number" name="phone"
                                value="{{ $userfamily->phone }}">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth: {{ $userfamily->dob }}</label>
                            <input id="dob" class="form-control" type="date" name="dob"
                                value="{{ $userfamily->dob }}">
                            @error('dob')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                            data-target="#editModal">Update Record</button>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                            aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your modal body content here -->
                                        <p>Are you sure you want to update this user?</p>
                                        <p><strong>Old Name:</strong> {{ $userfamily->name }}</p>
                                        <p><strong>Updated Name:</strong> <span id="updatedUserName"></span></p>
                                        <p><strong>Old Phone:</strong> {{ $userfamily->mobile }}</p>
                                        <p><strong>Updated Phone:</strong> <span id="updatedUserPhone"></span></p>
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
            document.getElementById('updatedUserName').textContent = this.value;
        });

        document.getElementById('phone').addEventListener('input', function() {
            document.getElementById('updatedUserPhone').textContent = this.value;
        });
    </script>
</x-admin-layout>
