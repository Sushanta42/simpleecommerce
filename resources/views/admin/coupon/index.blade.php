@php
    $statusColors = [
        'active' => 'success',
        'inactive' => 'warning',
        'expired' => 'danger',
    ];
@endphp
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
                    <a href="{{ route('coupon.create') }}" class="btn btn-primary btn-md">Add Coupon</a>
                    <h6>Coupons</h6>
                </div>
                <div class="card-body">
                    <table class="table" id="save-stage" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="border border-1">SN</th>
                                <th class="border border-1">Coupon Code</th>
                                <th class="border border-1">Discount Amount</th>
                                <th class="border border-1">Max Uses</th>
                                <th class="border border-1">Used</th>
                                <th class="border border-1">Valid From</th>
                                <th class="border border-1">Valid To</th>
                                <th class="border border-1">Active</th>
                                <th class="border border-1">User Phone</th>
                                <th class="border border-1">Action</th>
                            </tr>
                        </thead>

                        <tbody style="font-size: 14px">
                            @foreach ($coupons as $index => $item)
                                <tr>
                                    <td class="border border-1">{{ ++$index }}</td>
                                    <td class="border border-1">{{ $item->code }}</td>
                                    <td class="border border-1">{{ $item->discount_amount }}</td>
                                    <td class="border border-1">{{ $item->max_uses }}</td>
                                    <td class="border border-1">{{ $item->used }}</td>
                                    <td class="border border-1">{{ $item->valid_from }}</td>
                                    <td class="border border-1">{{ $item->valid_to }}</td>
                                    <td class="border border-1">
                                        <span
                                            class="badge badge-{{ $statusColors[$item->status] }}">{{ $item->status }}</span>
                                    </td>
                                    {{-- <td class="border border-1">
                                        <!-- Element to display the active status -->
                                        @if ($item->active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td> --}}
                                    {{-- <td class="border border-1">{{ $item->user->name }}</td> --}}
                                    <td class="border border-1">{{ $item->user->phone ?? 'null' }}</td>
                                    <td class="border border-1">
                                        <form action="{{ route('coupon.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')

                                            <div class="d-flex">
                                                <a href="{{ route('coupon.edit', $item->id) }}"
                                                    class="btn btn-info btn-sm mr-2">Edit</a>
                                                <!-- Add this code inside your index.blade.php file -->

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#deleteModal{{ $item->id }}">
                                                    Delete
                                                </button>
                                            </div>


                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="deleteModalLabel{{ $item->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="deleteModalLabel{{ $item->id }}">Delete
                                                                Confirmation</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this coupon?</p>
                                                            <p><strong>Coupon Code:</strong> {{ $item->code }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                data-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('coupon.destroy', $item->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
