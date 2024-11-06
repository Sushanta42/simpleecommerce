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
                    <a href="{{ route('imagemedia.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h4>Edit Uploaded Image Details</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('imagemedia.update', $imagemedia->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="user_id">User Phone</label>
                            <select id="user_id" class="form-control" name="user_id">
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($imagemedia->user_id == $item->id) selected @endif>{{ $item->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Upload Image</label>
                            <input id="image" class="form-control-file" type="file" name="image">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div>
                                <img src="{{ asset($imagemedia->image) }}" width="120" alt="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description (Optional)</label>
                            <textarea id="description" class="summernote" name="description" rows="4">{{ $imagemedia->description }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" name="status">
                                <option value="on_review" {{ $imagemedia->status == 'on_review' ? 'selected' : '' }}>On
                                    Review
                                </option>
                                <option value="completed" {{ $imagemedia->status == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                                <option value="cancelled" {{ $imagemedia->status == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled</option>
                            </select>
                            @error('status')
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
