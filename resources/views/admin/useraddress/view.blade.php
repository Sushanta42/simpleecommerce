<x-admin-layout>
    <section>
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('useraddress.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h4>Address Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_id">Name:</label>
                                <p class="form-control-static" id="user_id">{{ $useraddress->user->name }}</p>
                            </div>
                            <div class="form-group">
                                <label for="user_id">Email:</label>
                                <p class="form-control-static" id="user_id">{{ $useraddress->user->email ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="user_id">Phone:</label>
                                <p class="form-control-static" id="user_id">{{ $useraddress->user->phone }}</p>
                            </div>
                            <div class="form-group">
                                <label for="municipality">Municipality:</label>
                                <p class="form-control-static" id="municipality">
                                    {{ $useraddress->municipality ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="city">City:</label>
                                <p class="form-control-static" id="city">{{ $useraddress->city ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="ward">Ward:</label>
                                <p class="form-control-static" id="ward">{{ $useraddress->ward ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="coordinate">Coordinate:</label>
                                <p class="form-control-static" id="coordinate">{{ $useraddress->coordinate ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="longitude">Longitude:</label>
                                <p class="form-control-static" id="longitude">{{ $useraddress->longitude ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="latitude">Latitude:</label>
                                <p class="form-control-static" id="latitude">{{ $useraddress->latitude ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="house_image">House Image:</label>
                                <td class="border border-1">
                                    <a href="" data-toggle="modal" data-target="#houseModal{{ $useraddress->id }}">
                                        <img src="{{ asset($useraddress->house_image) }}" width="60" alt="">
                                    </a>
                                    <div class="modal fade" id="houseModal{{ $useraddress->id }}" tabindex="-1" role="dialog" aria-labelledby="houseImageLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div>
                                                    <img src="{{ asset($useraddress->house_image) }}" class="img-fluid" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </div>
                            <div class="form-group">
                                <label for="road_image">Road Image:</label>
                                <td class="border border-1">
                                    <a href="" data-toggle="modal" data-target="#roadModal{{ $useraddress->id }}">
                                        <img src="{{ asset($useraddress->road_image) }}" width="60" alt="">
                                    </a>
                                    <div class="modal fade" id="roadModal{{ $useraddress->id }}" tabindex="-1" role="dialog" aria-labelledby="roadImageLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div>
                                                    <img src="{{ asset($useraddress->road_image) }}" class="img-fluid" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('useraddress.edit', $useraddress->id) }}" class="btn btn-info btn-sm mr-2">Edit
                        Details</a>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
