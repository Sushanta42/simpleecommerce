<x-admin-layout>
    <section>
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('user.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h4>User Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <p class="form-control-static" id="name">{{ $user->name }}</p>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <p class="form-control-static" id="email">{{ $user->email ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <p class="form-control-static" id="phone">{{ $user->phone }}</p>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth:</label>
                                <p class="form-control-static" id="dob">{{ $user->dob ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="common_address_id">Common Address:</label>
                                <p class="form-control-static" id="common_address_id">{{ $user->common_address->name ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="description">Remarks:</label>
                                <p class="form-control-static" id="description">{!! $user->description ?? 'N/A' !!}</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info btn-sm mr-2">Edit Details</a>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
