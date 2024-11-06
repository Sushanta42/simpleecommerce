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
                    <h4>Edit Product</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('product.update', $product->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input id="name" class="form-control" type="text" name="name"
                                value="{{ $product->name }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description (Optional)</label>
                            <textarea id="description" class="summernote" name="description" rows="4">{{ $product->description }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select id="category_id" class="form-control" name="category_id">
                                <option value="">Select Categories</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $product->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
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


                        {{-- <div class="form-group">
                            <label for="subcategory_id">Sub Category</label>
                            <select id="subcategory_id" class="form-control" name="subcategory_id">
                                @foreach ($subcategories as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($product->sub_category_id == $item->id) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="price">Price (Rs)</label>
                            <input id="price" class="form-control" type="number" name="price"
                                oninput="calculate()" value="{{ $product->price }}">
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sale_price">Selling Price (Rs)</label>
                            <input id="sale_price" class="form-control" type="number" name="sale_price"
                                oninput="calculateDiscount()" value="{{ $product->sale_price }}">
                            @error('sale_price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="discount_percent">Discount Percent (%)</label>
                            <input id="discount_percent" class="form-control" type="number" name="discount_percent"
                                oninput="calculate()" value="{{ $product->discount_percent ?? 0 }}">
                            @error('discount_percent')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="availability">Availability</label>
                            <select id="availability" class="form-control" name="availability">
                                <option value="many_in_stock"
                                    {{ $product->availability == 'many_in_stock' ? 'selected' : '' }}>Many in stock
                                </option>
                                <option value="less_in_stock"
                                    {{ $product->availability == 'less_in_stock' ? 'selected' : '' }}>Less in stock
                                </option>
                                <option value="out_of_stock"
                                    {{ $product->availability == 'out_of_stock' ? 'selected' : '' }}>Out of stock
                                </option>
                            </select>
                            @error('availability')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="code">Enter Code to Update Label:</label>
                            <input id="code" class="form-control" type="password" name="code">
                            @error('code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="label">Label</label>
                            <select id="label" class="form-control" name="label" disabled>
                                <option value="hot" {{ $product->label == 'hot' ? 'selected' : '' }}>Hot</option>
                                <option value="sale" {{ $product->label == 'sale' ? 'selected' : '' }}>Sale</option>
                                <option value="new" {{ $product->label == 'new' ? 'selected' : '' }}>New</option>
                            </select>
                            @error('label')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Upload Image</label>
                            <input id="image" class="form-control-file" type="file" name="image">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div>
                                <img src="{{ asset($product->image) }}" width="120" alt="">
                            </div>
                        </div>
                        <!-- Display existing media -->
                        <div class="form-group">
                            <label>Existing Media:</label>
                            <div class="row">
                                @foreach ($product->media as $media)
                                    <div class="col-md-3 mb-3">
                                        @if ($media->media_type == 'image')
                                            <img src="{{ asset($media->file_path) }}" class="img-fluid"
                                                alt="Product Image">
                                        @elseif($media->media_type == 'video')
                                            <video width="100%" controls>
                                                <source src="{{ asset($media->file_path) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                        <br>
                                        <button type="button" class="btn btn-danger btn-sm mt-2"
                                            onclick="deleteMedia({{ $media->id }})">Delete</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Update media section -->
                        <div class="form-group">
                            <label for="media">Upload Additional Media (Optional)</label>
                            <input id="media" class="form-control-file" type="file" name="media[]" multiple>
                            @error('media.*')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-md">Update Record</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-vendor-layout>

<script>
    // Function to enable the "label" field when the correct code is entered
    function enableLabelField() {
        var codeInput = document.getElementById('code');
        var labelSelect = document.getElementById('label');

        codeInput.addEventListener('input', function() {
            if (codeInput.value === '112233') {
                labelSelect.removeAttribute('disabled');
            } else {
                labelSelect.setAttribute('disabled', 'disabled');
            }
        });
    }

    // Call the function to enable the "label" field
    enableLabelField();
</script>

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

        // Check if the product has a selected subcategory and set it as selected
        var productSubcategoryId = {{ $product->sub_category_id ?? 'null' }};
        if (productSubcategoryId) {
            var selectedOption = subcategorySelect.querySelector('option[value="' + productSubcategoryId + '"]');
            if (selectedOption) {
                selectedOption.selected = true;
            }
        }
    }

    // Attach the updateSubcategories function to the change event of the category dropdown
    document.getElementById('category_id').addEventListener('change', updateSubcategories);

    // Trigger the function on page load if there's a selected category (for editing)
    window.onload = function() {
        updateSubcategories();
    };
</script>

<script>
    function deleteMedia(mediaId) {
    if (confirm('Are you sure you want to delete this media?')) {
        // AJAX request to delete media
        $.ajax({
            url: '/vendor/product/media/delete/' + mediaId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    alert('Media deleted successfully');
                    // Optionally, remove the media element from the DOM
                    location.reload();
                } else {
                    alert(response.error);
                }
            },
            error: function(xhr) {
                alert('Failed to delete media');
            }
        });
    }
}

</script>

