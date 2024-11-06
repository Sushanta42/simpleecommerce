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
                <div class="card-header">
                    <a href="{{ route('useraddress.index') }}" class="btn btn-primary btn-sm">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('useraddress.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">User Phone</label>
                            <select id="user_id" class="form-control" name="user_id" value="{{ old('user_id') }}">
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
                            <label for="municipality">Municipality</label>
                            <input id="municipality" class="form-control" type="text" name="municipality"
                                value="{{ old('municipality') }}">
                            @error('municipality')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input id="city" class="form-control" type="text" name="city"
                                value="{{ old('city') }}">
                            @error('city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="ward">Ward</label>
                            <input id="ward" class="form-control" type="number" name="ward"
                                value="{{ old('ward') }}">
                            @error('ward')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tole">Tole</label>
                            <input id="tole" class="form-control" type="text" name="tole"
                                value="{{ old('tole') }}">
                            @error('tole')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="coordinate">Coordinate</label>
                            <input id="coordinate" class="form-control" type="text" name="coordinate"
                                value="{{ old('coordinate') }}">
                            @error('coordinate')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude (Optional/In decimal)</label>
                            <input id="longitude" class="form-control" type="text" name="longitude"
                                value="{{ old('longitude') }}">
                            @error('longitude')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="latitude">Latitude (Optional/In decimal)</label>
                            <input id="latitude" class="form-control" type="text" name="latitude"
                                value="{{ old('latitude') }}">
                            @error('latitude')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="house_image">Upload House Image</label>
                            <input id="house_image" class="form-control-file" type="file" name="house_image">
                            @error('house_image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="road_image">Upload Road Image</label>
                            <input id="road_image" class="form-control-file" type="file" name="road_image">
                            @error('road_image')
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
