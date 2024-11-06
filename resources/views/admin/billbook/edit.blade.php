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
                    <a href="{{ route('billbook.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h4>Edit Bluebook Details</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('billbook.update', $billbook->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $billbook->name }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input id="phone" class="form-control" type="number" name="phone"
                                value="{{ $billbook->phone }}">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email(Optional)</label>
                            <input id="email" class="form-control" type="email" name="email"
                                value="{{ $billbook->email }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="municipality">Municipality</label>
                            <input id="municipality" class="form-control" type="text" name="municipality"
                                value="{{ $billbook->municipality }}">
                            @error('municipality')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input id="address" class="form-control" type="text" name="address"
                                value="{{ $billbook->address }}">
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image_citizen">Upload Citizenship/License (Optional)</label>
                            <input id="image_citizen" class="form-control-file" type="file" name="image_citizen">
                            @error('image_citizen')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div>
                                <img src="{{ asset($billbook->image_citizen) }}" width="120" alt="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image_front">Upload Front Page(Optional)</label>
                            <input id="image_front" class="form-control-file" type="file" name="image_front">
                            @error('image_front')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div>
                                <img src="{{ asset($billbook->image_front) }}" width="120" alt="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">Upload Image(Optional)</label>
                            <input id="image" class="form-control-file" type="file" name="image">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div>
                                <img src="{{ asset($billbook->image) }}" width="120" alt="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="vehicle_type">Vehicle type</label>
                            <select id="vehicle_type" class="form-control" name="vehicle_type">
                                <option value="2_wheeler"
                                    {{ $billbook->vehicle_type == '2_wheeler' ? 'selected' : '' }}>2
                                    Wheeler
                                </option>
                                <option value="4_wheeler"
                                    {{ $billbook->vehicle_type == '4_wheeler' ? 'selected' : '' }}>4
                                    Wheeler
                                </option>
                                <option value="others" {{ $billbook->vehicle_type == 'others' ? 'selected' : '' }}>
                                    Others
                                </option>
                            </select>
                            @error('vehicle_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" name="status">
                                <option value="on_review" {{ $billbook->status == 'on_review' ? 'selected' : '' }}>On
                                    Review
                                </option>
                                <option value="completed" {{ $billbook->status == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                                <option value="cancelled" {{ $billbook->status == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="renewal_date">Renewal Date(Optional)</label>
                            <input id="renewal_date" class="form-control" type="date" name="renewal_date"
                                value="{{ $billbook->renewal_date }}">
                            @error('renewal_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="billbook_status">Billbook Status</label>
                            <select id="billbook_status" class="form-control" name="billbook_status">
                                <option value="active" {{ $billbook->billbook_status == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="notice_time"
                                    {{ $billbook->billbook_status == 'notice_time' ? 'selected' : '' }}>Notice Time
                                </option>
                                <option value="expiry" {{ $billbook->billbook_status == 'expiry' ? 'selected' : '' }}>
                                    Expiry</option>
                            </select>
                            @error('billbook_status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description (Optional)</label>
                            <textarea id="description" class="summernote" name="description" rows="4">{{ $billbook->description }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-md">Save Record</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
