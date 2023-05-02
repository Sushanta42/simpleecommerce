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
                    <a href="{{ route('subcategory.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h6>Edit Category</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('subcategory.update', $subcategory->id) }}" method="post",
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name">Sub Category Name</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $subcategory->name }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select id="category_id" class="form-control" name="category_id">
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($subcategory->category_id == $item->id) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Upload Image</label>
                            <input id="image" class="form-control-file" type="file" name="image">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <img src="{{ asset($subcategory->image) }}" width="120" alt="">
                        </div>

                        <br />

                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                            data-target="#editModal">Update Record</button>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                            aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your modal body content here -->
                                        <p>Are you sure you want to update this category?</p>
                                        <p><strong>Old SubCategory:</strong> {{ $subcategory->name }}</p>
                                        <p><strong>Updated SubCategory:</strong> <span
                                                id="updatedSubCategoryName"></span>
                                        </p>
                                        <p><strong>Old Category:</strong> {{ $subcategory->category->name }}</p>
                                        <p><strong>UpdatedCategory:</strong> <span id="updatedCategory"></span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Update the modal body with the updated subcategory name
        document.getElementById('name').addEventListener('input', function() {
            document.getElementById('updatedSubCategoryName').textContent = this.value;
        });

        // Update the modal body with the selected category name
        document.getElementById('category_id').addEventListener('change', function() {
            var categorySelect = document.getElementById('category_id');
            var selectedCategory = categorySelect.options[categorySelect.selectedIndex].text;
            document.getElementById('updatedCategory').textContent = selectedCategory;
        });
    </script>

</x-admin-layout>
