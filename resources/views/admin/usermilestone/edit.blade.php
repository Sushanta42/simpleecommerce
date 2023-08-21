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
                    <a href="{{ route('usermilestone.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h4>Edit User MileStone Plan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('usermilestone.update', $usermilestone->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="user_id">User Name</label>
                            <input type="hidden" name="user_id" value="{{ $usermilestone->user_id }}">

                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $usermilestone->user->name }}" disabled>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="user_id">User Phone</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $usermilestone->user->phone }}" disabled>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="milestone_id">MileStone Plan</label>
                            <input type="hidden" name="milestone_id" value="{{ $usermilestone->milestone_id }}">

                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $usermilestone->milestone->name }}" disabled>
                            {{-- <select id="milestone_id" class="form-control" name="milestone_id" disabled>
                                @foreach ($milestones as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($usermilestone->milestone_id == $item->id) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select> --}}
                            @error('milestone_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" name="status">
                                <option value="active" {{ $usermilestone->status == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="expired" {{ $usermilestone->status == 'expired' ? 'selected' : '' }}>
                                    Expired
                                </option>
                                <option value="cancelled"
                                    {{ $usermilestone->status == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="reward">Reward</label>
                            <select id="reward" class="form-control" name="reward">
                                <option value="unclaimed"
                                    {{ $usermilestone->reward == 'unclaimed' ? 'selected' : '' }}>
                                    Unclaimed
                                </option>
                                <option value="claimed" {{ $usermilestone->reward == 'claimed' ? 'selected' : '' }}>
                                    Claimed
                                </option>
                            </select>
                            @error('reward')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label for="destination">Destination</label>
                            <select id="destination" class="form-control" name="destination">
                                <option value="ongoing"
                                    {{ $usermilestone->destination == 'ongoing' ? 'selected' : '' }}>
                                    Ongoing
                                </option>
                                <option value="reached"
                                    {{ $usermilestone->destination == 'reached' ? 'selected' : '' }}>
                                    Reached
                                </option>
                            </select>
                            @error('destination')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <button type="submit" class="btn btn-primary btn-md">Update Record</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
