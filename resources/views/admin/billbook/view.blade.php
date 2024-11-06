<x-admin-layout>
    <section>
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('billbook.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h4>Edit Bluebook Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <p class="form-control-static" id="name">{{ $billbook->name }}</p>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <p class="form-control-static" id="phone">{{ $billbook->phone }}</p>
                            </div>
                            <div class="form-group">
                                <label for="email">Email(Optional):</label>
                                <p class="form-control-static" id="email">{{ $billbook->email ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="municipality">Municipality:</label>
                                <p class="form-control-static" id="municipality">{{ $billbook->municipality ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <p class="form-control-static" id="address">{{ $billbook->address }}</p>
                            </div>
                            <div class="form-group">
                                <label for="image_citizen">Citizenship/License Image:</label>
                                <td class="border border-1">
                                    <a href="" data-toggle="modal" data-target="#productModal{{ $billbook->id }}">
                                        <img src="{{ asset($billbook->image_citizen) }}" width="60" alt="">
                                    </a>
                                    <div class="modal fade" id="productModal{{ $billbook->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="productImageLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div>
                                                    <img src="{{ asset($billbook->image_citizen) }}" class="img-fluid"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </div>
                            <div class="form-group">
                                <label for="image_front">Front Image:</label>
                                <td class="border border-1">
                                    <a href="" data-toggle="modal" data-target="#houseModal{{ $billbook->id }}">
                                        <img src="{{ asset($billbook->image_front) }}" width="60" alt="">
                                    </a>
                                    <div class="modal fade" id="houseModal{{ $billbook->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="houseImageLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div>
                                                    <img src="{{ asset($billbook->image_front) }}" class="img-fluid"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </div>
                            <div class="form-group">
                                <label for="image">Main Image:</label>
                                <td class="border border-1">
                                    <a href="" data-toggle="modal" data-target="#roadModal{{ $billbook->id }}">
                                        <img src="{{ asset($billbook->image) }}" width="60" alt="">
                                    </a>
                                    <div class="modal fade" id="roadModal{{ $billbook->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="roadImageLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div>
                                                    <img src="{{ asset($billbook->image) }}" class="img-fluid"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vehicle_type">Vehicle type:</label>
                                <p class="form-control-static" id="vehicle_type">{{ $billbook->vehicle_type }}</p>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <p class="form-control-static" id="status">{{ $billbook->status }}</p>
                            </div>
                            <div class="form-group">
                                <label for="renewal_date">Renewal Date(Optional):</label>
                                <p class="form-control-static" id="renewal_date">{{ $billbook->renewal_date ?? 'N/A'}}</p>
                            </div>
                            <div class="form-group">
                                <label for="billbook_status">Billbook Status:</label>
                                <p class="form-control-static" id="billbook_status">{{ $billbook->billbook_status }}</p>
                            </div>
                            <div class="form-group">
                                <label for="description">Description (Optional):</label>
                                <p class="form-control-static" id="description">{{ $billbook->description }}</p>
                            </div>
                        </div>
                        <a href="{{ route('billbook.edit', $billbook->id) }}" class="btn btn-info btn-sm mr-2">Edit
                            Details</a>
                    </div>
                </div>
            </div>
    </section>
</x-admin-layout>
