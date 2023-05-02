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
                    <a href="{{ route('uservendor.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h4>Edit Vendor</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('uservendor.update', $vendor->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $vendor->name }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" class="form-control" type="email" name="email"
                                value="{{ $vendor->email }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input id="phone" class="form-control" type="number" name="phone"
                                value="{{ $vendor->phone }}">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="common_address_id">Common Address</label>
                            <select id="common_address_id" class="form-control" name="common_address_id">
                                @foreach ($commonaddresses as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($vendor->common_address_id == $item->id) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                            data-target="#editModal">Update Record</button>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                            aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Vendor</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your modal body content here -->
                                        <p>Are you sure you want to update this vendor?</p>
                                        <p><strong>Old Name:</strong> {{ $vendor->name }}</p>
                                        <p><strong>Updated Name:</strong> <span id="updatedUserName"></span></p>
                                        <p><strong>Old Email:</strong> {{ $vendor->email }}</p>
                                        <p><strong>Updated Email:</strong> <span id="updatedUserEmail"></span></p>
                                        <p><strong>Old Phone:</strong> {{ $vendor->phone }}</p>
                                        <p><strong>Updated Phone:</strong> <span id="updatedUserPhone"></span></p>
                                        {{-- <p><strong>Old Address:</strong> {{ $vendor->common_address->name }}</p>
                                        <p><strong>Updated Address:</strong> <span id="updatedAddress"></span> --}}
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
        document.getElementById('email').addEventListener('input', function() {
            document.getElementById('updatedUserEmail').textContent = this.value;
        });

        document.getElementById('phone').addEventListener('input', function() {
            document.getElementById('updatedUserPhone').textContent = this.value;
        });

        // Update the modal body with the selected address name
        // document.getElementById('common_address_id').addEventListener('change', function() {
        //     var addressSelect = document.getElementById('common_address_id');
        //     var selectedAddress = addressSelect.options[addressSelect.selectedIndex].text;
        //     document.getElementById('updatedAddress').textContent = selectedAddress;
        // });
    </script>
</x-admin-layout>
