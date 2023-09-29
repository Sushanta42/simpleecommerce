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
                    <a href="{{ route('milestone.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h4>Add MileStone Plan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('milestone.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Plan Name</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="plan">Plan</label>
                            <select id="plan" class="form-control" name="plan">
                                <option value="">Select Plan</option>
                                <option value="bronze" {{ old('plan') == 'bronze' ? 'selected' : '' }}>Bronze
                                </option>
                                <option value="silver" {{ old('plan') == 'silver' ? 'selected' : '' }}>Silver
                                </option>
                                <option value="gold" {{ old('plan') == 'gold' ? 'selected' : '' }}>Gold
                                </option>
                                <option value="platium" {{ old('plan') == 'platium' ? 'selected' : '' }}>Platium
                                </option>
                            </select>
                            @error('plan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description (Optional)</label>
                            <textarea id="description" class="summernote" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="goal">Goal (Rs)</label>
                            <input id="goal" class="form-control" type="number" name="goal"
                                value="{{ old('goal') }}">
                            @error('goal')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration(In Days)</label>
                            <input id="duration" class="form-control" type="number" name="duration"
                                value="{{ old('duration') }}">
                            @error('duration')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" name="status">
                                <option value="">Select status</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
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
                        {{-- <div class="form-group">
                            <label for="type">Type</label>
                            <select id="type" class="form-control" name="type">
                                <option value="days" {{ old('type') == 'days' ? 'selected' : '' }}>
                                    Days
                                </option>
                                <option value="months" {{ old('type') == 'months' ? 'selected' : '' }}>
                                    Months
                                </option>
                                <option value="year" {{ old('type') == 'year' ? 'selected' : '' }}>Year</option>
                            </select>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="active">Active</label>
                            <select id="active" name="active" class="form-control">
                                <option value="">Select</option>
                                <option value="1"{{ old('active') == '1' ? ' selected' : '' }}>Yes</option>
                                <option value="0"{{ old('active') == '0' ? ' selected' : '' }}>No</option>
                            </select>
                            @error('active')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <button type="submit" class="btn btn-primary btn-md">Save Plan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
