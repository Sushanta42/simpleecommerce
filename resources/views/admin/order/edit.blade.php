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
                    <a href="{{ route('order.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h6>Edit Order</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('order.update', $order->id) }}" method="post",
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="user_id">User Name</label>
                            <input type="hidden" name="user_id" value="{{ $order->user_id }}">

                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $order->user->name }}" disabled>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="user_id">User Phone</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $order->user->phone }}" disabled>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="total">Total Amount</label>
                            <input id="total" class="form-control" type="text" name="name"
                                value="{{ $order->total }}" disabled>
                            @error('total')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" name="status">
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                    Processing
                                </option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                    Delivered
                                </option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="delivered_time">Delivered/Cancelled At</label>
                            <input type="datetime-local" name="delivered_time" id="delivered_time" class="form-control"
                                value="{{ $order->delivered_time }}">
                            @error('delivered_time')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                            data-target="#editModal">Update Order</button>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                            aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your modal body content here -->
                                        <p>Are you sure you want to update this order?</p>
                                        <p><strong>Old Status:</strong> {{ $order->status }}</p>
                                        <p><strong>Updated Status:</strong> <span id="updatedCategoryName"></span></p>
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
        document.getElementById('status').addEventListener('input', function() {
            document.getElementById('updatedCategoryName').textContent = this.value;
        });
    </script>
</x-admin-layout>
