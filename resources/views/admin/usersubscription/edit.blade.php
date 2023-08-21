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
                    <h4>Edit User Subscription Plan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('usersubscription.update', $usersubscription->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="user_id">User Name</label>
                            <input type="hidden" name="user_id" value="{{ $usersubscription->user_id }}">

                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $usersubscription->user->name }}" disabled>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="user_id">User Phone</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $usersubscription->user->phone }}" disabled>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="subscription_id">Subscription Plan</label>
                            <select id="subscription_id" class="form-control" name="subscription_id">
                                @foreach ($subscriptions as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($usersubscription->subscription_id == $item->id) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('subscription_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" name="status">
                                <option value="active" {{ $usersubscription->status == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="expired" {{ $usersubscription->status == 'expired' ? 'selected' : '' }}>
                                    Expired
                                </option>
                                <option value="cancelled"
                                    {{ $usersubscription->status == 'cancelled' ? 'selected' : '' }}>
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
                                <option value="1"{{ $usersubscription->paid == '1' ? ' selected' : '' }}>Yes
                                </option>
                                <option value="0"{{ $usersubscription->paid == '0' ? ' selected' : '' }}>No
                                </option>
                            </select>
                            @error('paid')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="renewal_date">Renewal Date:</label>
                            <input type="date" name="renewal_date" id="renewal_date" class="form-control"
                                value="{{ $usersubscription->renewal_date }}">
                        </div>

                        <button type="submit" class="btn btn-primary btn-md">Update Record</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
