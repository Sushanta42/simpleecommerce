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
                    <a href="{{ route('useraddress.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h6>Edit User Address</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('useraddress.update', $useraddress->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="user_id">User Phone</label>
                            <select id="user_id" class="form-control" name="user_id">
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($useraddress->user_id == $item->id) selected @endif>{{ $item->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="municipality">Municipality</label>
                            <input id="municipality" class="form-control" type="text" name="municipality"
                                value="{{ $useraddress->municipality }}">
                            @error('municipality')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input id="city" class="form-control" type="text" name="city"
                                value="{{ $useraddress->city }}">
                            @error('city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="ward">Ward</label>
                            <input id="ward" class="form-control" type="number" name="ward"
                                value="{{ $useraddress->ward }}">
                            @error('ward')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tole">Tole</label>
                            <input id="tole" class="form-control" type="text" name="tole"
                                value="{{ $useraddress->tole }}">
                            @error('tole')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="coordinate">Coordinate</label>
                            <input id="coordinate" class="form-control" type="text" name="coordinate"
                                value="{{ $useraddress->coordinate }}">
                            @error('coordinate')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude (Optional)</label>
                            <input id="longitude" class="form-control" type="text" name="longitude"
                                value="{{ $useraddress->longitude }}">
                            @error('longitude')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="latitude">Latitude (Optional)</label>
                            <input id="latitude" class="form-control" type="text" name="latitude"
                                value="{{ $useraddress->latitude }}">
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
