@php
    $planColors = [
        'basic' => 'light',
        'standard' => 'info',
        'premium' => 'warning',
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
                    <a href="{{ route('subscription.create') }}" class="btn btn-primary btn-md">Add Subscription</a>
                    <h4>Subscription Details</h4>
                </div>
                <div class="card-body">
                    <table class="table" id="save-stage" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="border border-1">SN</th>
                                <th class="border border-1">Name</th>
                                <th class="border border-1">Description</th>
                                <th class="border border-1">Price (Rs.)</th>
                                <th class="border border-1">Duration</th>
                                <th class="border border-1">Type</th>
                                <th class="border border-1">Plan</th>
                                <th class="border border-1">Active</th>
                                <th class="border border-1">Created At</th>
                                <th class="border border-1">Updated At</th>
                                <th class="border border-1">Action</th>
                            </tr>
                        </thead>

                        <tbody style="font-size: 14px">
                            @foreach ($subscriptions as $index => $item)
                                <tr class="border border-1">
                                    <td class="border border-1">{{ ++$index }}</td>
                                    <td class="border border-1">{{ $item->name }}</td>
                                    <td class="border border-1">{!! $item->description !!}</td>
                                    <td class="border border-1">{{ $item->price }}</td>
                                    <td class="border border-1">{{ $item->duration }}</td>
                                    <td class="border border-1">{{ $item->type }}</td>
                                    <td class="border border-1">
                                        <span
                                            class="badge badge-{{ $planColors[$item->plan] }}">{{ $item->plan }}</span>
                                    </td>
                                    <td class="border border-1">
                                        <!-- Element to display the active status -->
                                        @if ($item->active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="border border-1">{{ $item->created_at }}</td>
                                    <td class="border border-1">{{ $item->updated_at }}</td>
                                    <td class="border border-1">
                                        <form action="{{ route('subscription.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')

                                            <div class="d-flex">
                                                <a href="{{ route('subscription.edit', $item->id) }}"
                                                    class="btn btn-primary btn-sm mr-2">Edit</a>

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger btn-sm mr-2"
                                                    data-toggle="modal" data-target="#deleteModal{{ $item->id }}">
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
                                                            <p>Are you sure you want to delete this plan?</p>
                                                            <p><strong>Plan Name:</strong> {{ $item->name }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                data-dismiss="modal">Cancel</button>
                                                            <form
                                                                action="{{ route('subscription.destroy', $item->id) }}"
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
                    {{-- {{ $users->links('pagination::bootstrap-5') }} --}}
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>
