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
                    <form action="{{ route('milestone.update', $milestone->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name">Plan Name</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $milestone->name }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="plan">Plan</label>
                            <select id="plan" class="form-control" name="plan">
                                <option value="bronze" {{ $milestone->plan == 'bronze' ? 'selected' : '' }}>Bronze
                                </option>
                                <option value="silver" {{ $milestone->plan == 'silver' ? 'selected' : '' }}>Silver
                                </option>
                                <option value="gold" {{ $milestone->plan == 'gold' ? 'selected' : '' }}>Gold
                                </option>
                                <option value="platium" {{ $milestone->plan == 'platium' ? 'selected' : '' }}>Platium
                                </option>
                            </select>
                            @error('plan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description (Optional)</label>
                            <textarea id="description" class="summernote" name="description" rows="4">{{ $milestone->description }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="goal">Goal</label>
                            <input id="goal" class="form-control" type="number" name="goal"
                                value="{{ $milestone->goal }}">
                            @error('goal')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration(In Days)</label>
                            <input id="duration" class="form-control" type="number" name="duration"
                                value="{{ $milestone->duration }}">
                            @error('duration')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" name="status">
                                <option value="active" {{ $milestone->status == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ $milestone->status == 'inactive' ? 'selected' : '' }}>Inactive
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
                            <div>
                                <img src="{{ asset($milestone->image) }}" width="120" alt="">
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="type">Type</label>
                            <select id="type" class="form-control" name="type">
                                <option value="days" {{ $milestone->type == 'days' ? 'selected' : '' }}>
                                    Days
                                </option>
                                <option value="months" {{ $milestone->type == 'months' ? 'selected' : '' }}>
                                    Months
                                </option>
                                <option value="year" {{ $milestone->type == 'year' ? 'selected' : '' }}>Year</option>
                            </select>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <button type="submit" class="btn btn-primary btn-md">Update Plan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
