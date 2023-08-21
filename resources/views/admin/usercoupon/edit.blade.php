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
                    <a href="{{ route('usercoupon.index') }}" class="btn btn-primary btn-sm">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('usercoupon.update', $usercoupons->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="user_id">User Number</label>
                            <select id="user_id" class="form-control" name="user_id">
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($usercoupons->user_id == $item->id) selected @endif>{{ $item->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="coupon_id">Coupon Code</label>
                            <select id="coupon_id" class="form-control" name="coupon_id">
                                @foreach ($coupons as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($usercoupons->coupon_id == $item->id) selected @endif>{{ $item->code }}</option>
                                @endforeach
                            </select>
                            @error('coupon_id')
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
