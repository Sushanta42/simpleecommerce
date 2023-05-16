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
                    <a href="{{ route('usersubscription.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h4>Add User Subscription</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('usersubscription.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">User Detail</label>
                            <select id="user_id" class="form-control" name="user_id">
                                <option value="">Select User</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->phone }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="subscription_id">Subscription Plan</label>
                            <select id="subscription_id" class="form-control" name="subscription_id">
                                <option value="">Select Plan</option>
                                @foreach ($subscriptions as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('subscription_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" name="status">
                                <option value="">Select Status</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired
                                </option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="paid">Paid</label>
                            <select id="paid" name="paid" class="form-control">
                                <option value="">Select</option>
                                <option value="1"{{ old('paid') == '1' ? ' selected' : '' }}>Yes</option>
                                <option value="0"{{ old('paid') == '0' ? ' selected' : '' }}>No</option>
                            </select>
                            @error('paid')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-md">Save Plan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
