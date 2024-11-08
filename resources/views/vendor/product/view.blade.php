<x-vendor-layout>
    <section>
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('product.index') }}" class="btn btn-primary btn-sm">Back</a>
                    <h4>Product Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Product Name:</label>
                                <div class="form-control-static" id="name"
                                    style="border: 1px solid #c8c4c4; padding: 10px;">
                                    {{ $product->name }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <div class="form-control-static" id="description"
                                    style="border: 1px solid #c8c4c4; padding: 10px;">
                                    {!! $product->description ?? 'N/A' !!}</div>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category:</label>
                                <div class="form-control-static" id="category_id"
                                    style="border: 1px solid #c8c4c4; padding: 10px;">
                                    {{ $product->category->name }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sub_category_id">Sub Category:</label>
                                <div class="form-control-static" id="sub_category_id"
                                    style="border: 1px solid #c8c4c4; padding: 10px;">
                                    {{ $product->sub_category->name ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="availability">Availability:</label>
                                <div class="form-control-static" id="availability"
                                    style="border: 1px solid #c8c4c4; padding: 10px;">
                                    {{ $product->availability }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="label">Label:</label>
                                <div class="form-control-static" id="label"
                                    style="border: 1px solid #c8c4c4; padding: 10px;">
                                    {{ $product->label }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price">Price (Rs):</label>
                                <div class="form-control-static" id="price"
                                    style="border: 1px solid #c8c4c4; padding: 10px;">
                                    {{ $product->price }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sale_price">Selling Price (Rs)</label>
                                <div class="form-control-static" id="sale_price"
                                    style="border: 1px solid #c8c4c4; padding: 10px;">
                                    {{ $product->sale_price }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="discount_percent">Discount Percent (%)</label>
                                <div class="form-control-static" id="discount_percent"
                                    style="border: 1px solid #c8c4c4; padding: 10px;">
                                    {{ $product->discount_percent }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image">Image:</label>
                                <div>
                                    <td class="border border-1">
                                        <a href="" data-toggle="modal"
                                            data-target="#productModal{{ $product->id }}">
                                            <img src="{{ asset($product->image) }}" width="120" alt="">
                                        </a>
                                        <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="productImageLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div>
                                                        <img src="{{ asset($product->image) }}" class="img-fluid"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image">Images and Videos:</label>
                                <div class="row">
                                    @foreach($product->media as $media)
                                        <div class="col-md-4 mb-3">
                                            @if($media->media_type === 'image')
                                                <a href="{{ asset($media->file_path) }}" data-toggle="modal"
                                                    data-target="#productModal{{ $media->id }}">
                                                    <img src="{{ asset($media->file_path) }}" class="img-fluid"
                                                        alt="Image">
                                                </a>
                                            @elseif($media->media_type === 'video')
                                                <video width="100%" controls>
                                                    <source src="{{ asset($media->file_path) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @endif
                                            <!-- Modal -->
                                            <div class="modal fade" id="productModal{{ $media->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="productMediaLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            @if($media->media_type === 'image')
                                                                <img src="{{ asset($media->file_path) }}"
                                                                    class="img-fluid" alt="Image">
                                                            @elseif($media->media_type === 'video')
                                                                <video width="100%" controls>
                                                                    <source src="{{ asset($media->file_path) }}"
                                                                        type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-info btn-sm mr-2">Edit
                        Details</a>
                </div>
            </div>
        </div>
    </section>
</x-vendor-layout>
