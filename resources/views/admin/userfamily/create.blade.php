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
                    <h4>Customer</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('userfamily.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">User Number</label>
                            <select id="user_id" class="form-control" name="user_id"
                                value="{{ old('user_id') }}">
                                <option value="">Select User Number</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->phone }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input id="mobile" class="form-control" type="number" name="mobile"
                                value="{{ old('mobile') }}">
                            @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone (Optional)</label>
                            <input id="phone" class="form-control" type="number" name="phone"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input id="dob" class="form-control" type="date" name="dob"
                                value="{{ old('dob') }}">
                            @error('dob')
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
