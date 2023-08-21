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
                    <a href="{{ route('coupon.index') }}" class="btn btn-primary btn-sm">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('coupon.update', $coupon->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="user_id">User Name</label>
                            <select id="user_id" class="form-control" name="user_id">
                                <option value="">Select User</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($coupon->user_id == $item->id) selected @endif>{{ $item->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label for="user_id">User Name</label>
                            <select id="user_id" class="form-control" name="user_id">
                                <option value="{{ $coupon->user_id }}">Select User</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <label for="code">Coupon Code</label>
                            <input id="code" class="form-control" type="text" name="code"
                                value="{{ $coupon->code }}" maxlength="5" disabled>
                            @error('code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description (Optional)</label>
                            <textarea id="description" class="summernote" name="description" rows="4">{{ $coupon->description }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="discount_amount">Discount Amount</label>
                            <input id="discount_amount" class="form-control" type="number" name="discount_amount"
                                value="{{ $coupon->discount_amount }}">
                            @error('discount_amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="max_uses">Max Uses</label>
                            <input id="max_uses" class="form-control" type="text" name="max_uses" maxlength="1"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                value="{{ $coupon->max_uses }}">
                            @error('max_uses')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label for="used">Used</label>
                            <input id="used" class="form-control" type="text" name="used" maxlength="1"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                value="{{ $coupon->used, isset($used) ? $used : '') }}">
                            @error('used')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <label for="valid_from">Valid From : {{ $coupon->valid_from }}</label>
                            <input id="valid_from" class="form-control" type="date" name="valid_from"
                                value="{{ $coupon->valid_from }}">
                            @error('valid_from')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="valid_to">Valid To : {{ $coupon->valid_to }}</label>
                            <input id="valid_to" class="form-control" type="date" name="valid_to"
                                value="{{ $coupon->valid_to }}">
                            @error('valid_to')
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
