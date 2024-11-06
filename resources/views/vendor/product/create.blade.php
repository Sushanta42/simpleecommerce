<x-vendor-layout>
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
                    <a href="{{ route('product.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h4>Add Product</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description (Optional)</label>
                            <textarea id="description" class="summernote" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select id="category_id" class="form-control" name="category_id">
                                <option value="">Select Categories</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="subcategory_id">Sub Category</label>
                            <select id="subcategory_id" class="form-control" name="subcategory_id">
                                <option value="">Select SubCategories</option>
                                <!-- Subcategories will be populated dynamically using JavaScript -->
                            </select>
                            @error('subcategory_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Price (Rs)</label>
                            <input id="price" class="form-control" type="number" name="price"
                                oninput="calculate()" value="{{ old('price') }}">
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sale_price">Selling Price (Rs)</label>
                            <input id="sale_price" class="form-control" type="number" name="sale_price"
                                oninput="calculateDiscount()" value="{{ old('sale_price') }}">
                            @error('sale_price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="discount_percent">Discount Percent (%)</label>
                            <input id="discount_percent" class="form-control" type="number" name="discount_percent"
                                oninput="calculate()" value="{{ old('discount_percent') ?? 0 }}">
                            @error('discount_percent')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="availability">Availability</label>
                            <select id="availability" class="form-control" name="availability">
                                <option value="many_in_stock"
                                    {{ old('availability') == 'many_in_stock' ? 'selected' : '' }}>Many in stock
                                </option>
                                <option value="less_in_stock"
                                    {{ old('availability') == 'less_in_stock' ? 'selected' : '' }}>Less in stock
                                </option>
                                <option value="out_of_stock"
                                    {{ old('availability') == 'out_of_stock' ? 'selected' : '' }}>Out of stock</option>
                            </select>
                            @error('availability')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Upload Image</label>
                            <input id="image" class="form-control-file" type="file" name="image">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="media">Upload Media (Images or Videos)</label>
                            <input id="media" class="form-control-file" type="file" name="media[]" multiple>
                            @error('media')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="media">Upload Media (Images or Videos) (Optional)</label>
                            <input id="media" class="form-control-file" type="file" name="media[]" multiple>
                            @error('media')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-md">Save Record</button>
                    </form>
                </div>
            </div>
            <script>
                // Function to update subcategories based on the selected category
                function updateSubcategories() {
                    var categoryId = document.getElementById('category_id').value;
                    var subcategorySelect = document.getElementById('subcategory_id');
                    subcategorySelect.innerHTML = ''; // Clear existing options

                    // Populate subcategories based on the selected category
                    @foreach ($categories as $item)
                        if (categoryId == {{ $item->id }}) {
                            @foreach ($item->subcategories as $subcategory)
                                var option = document.createElement('option');
                                option.value = {{ $subcategory->id }};
                                option.text = '{{ $subcategory->name }}';
                                subcategorySelect.add(option);
                            @endforeach
                        }
                    @endforeach
                }

                // Attach the updateSubcategories function to the change event of the category dropdown
                document.getElementById('category_id').addEventListener('change', updateSubcategories);

                // Trigger the function on page load if there's a selected category (for editing)
                window.onload = function() {
                    updateSubcategories();
                };
            </script>
        </div>
    </section>
</x-vendor-layout>
