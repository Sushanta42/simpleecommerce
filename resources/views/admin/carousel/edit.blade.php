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
                    <a href="{{ route('carousel.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h4>Edit About Us</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('carousel.update', $carousel->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name"> Name</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $carousel->name }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Upload Image</label>
                            <input id="image" class="form-control-file" type="file" name="image">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" name="status">
                                <option value="active" {{ $carousel->status == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ $carousel->status == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="display_on">Display On</label>
                            <select id="display_on" class="form-control" name="display_on">
                                <option value="home" {{ $carousel->display_on == 'home' ? 'selected' : '' }}>Home
                                </option>
                                <option value="subscription"
                                    {{ $carousel->display_on == 'subscription' ? 'selected' : '' }}>Subscription
                                </option>
                                <option value="both" {{ $carousel->display_on == 'both' ? 'selected' : '' }}>Both
                                </option>
                            </select>
                            @error('display_on')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description (Optional)</label>
                            <textarea id="description" class="summernote" name="description" rows="4">{{ $carousel->description }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="link_to">Link To</label>
                            <input id="link_to" class="form-control" type="text" name="link_to"
                                value="{{ $carousel->link_to }}">
                            @error('link_to')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-md">Update Record</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
