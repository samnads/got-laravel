@extends('layouts.user', ['body_css_class' => ''])
@section('title', 'New Product')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">New Product</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><i class="bx bx-home-alt"></i>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Products</li>
                    <li class="breadcrumb-item active" aria-current="page">New</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <form id="new-product-form" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body p-4">
                <input type="hidden" name="action" value="quick-add" />
                <div class="row g-3">
                    <div class="col-md-7">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="dfdfdf" class="form-label">Name
                                    <rf />
                                </label>
                                <div class="position-relative">
                                    <input type="text" class="form-control" id="dfdfdf" name="name"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="sdfgdg" class="form-label">Category
                                    <rf />
                                </label>
                                <div class="position-relative">
                                    <select class="form-control" id="sdfgdg" name="category_id" autocomplete="off"
                                        placeholder="Search category...">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="gdassd" class="form-label">Brand</label>
                                <div class="position-relative">
                                    <select class="form-control" id="gdassd" name="brand_id" autocomplete="off">
                                        <option value="">-- Select Brand --</option>
                                        @foreach ($brands as $key => $brand)
                                            <option value="{{ $brand->value }}">{{ $brand->label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="hsfbzs" class="form-label">Unit
                                    <rf />
                                </label>
                                <div class="position-relative">
                                    <select type="text" class="form-control" id="hsfbzs" name="unit_id"
                                        autocomplete="off">
                                        <option value=""> -- Select Unit --</option>
                                        @foreach ($units as $key => $unit)
                                            <option value="{{ $unit->value }}">{{ $unit->label }}
                                                ({{ $unit->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label for="desdssw" class="form-label">Description
                                </label>
                                <div class="position-relative">
                                    <textarea class="form-control" id="desdssw" name="description"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-light">
                <input type="hidden" name="variation_theme_id" value="1" />
                <!--<input type="hidden" name="variat_id" value="1" />-->
                <div class="d-flex">
                    <div class="p-2 flex-grow-1"><span class="text-dark"><span class="fs-6">Product have variations
                                ?</span></span>&nbsp;&nbsp;&nbsp;
                        <span class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="have_variations" id="visinaurgh"
                                value="0">
                            <label class="form-check-label" for="visinaurgh" style="cursor: pointer">
                                NO
                            </label>
                        </span>
                        <span class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="have_variations" id="visinaurgy"
                                value="1" checked>
                            <label class="form-check-label" for="visinaurgy" style="cursor: pointer">
                                YES
                            </label>
                        </span>
                    </div>
                    <div class="p-0 mt-2"><button style="display: none" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="New Variant" type="button" class="btn btn-sm btn-info"
                            data-action="append-variant"><i class="fadeIn animated bx bx-plus"></i></button></div>
                </div>
            </div>
            <div class="card-body">
                <div id="size-variants" style="display: none">
                    <div class="row g-3 pb-3 pt-3 border-bottom" data-row="size-variant">
                        <input type="hidden" name="variants[]">
                        <div class="col-md-2">
                            <label class="form-label">Code
                                <rf />
                            </label>
                            <div class="position-relative">
                                <input type="text" class="form-control no-arrow variant_codes"
                                    name="variant_codes[0]" autocomplete="off" placeholder="GO001234">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Size
                                <rf />
                            </label>
                            <div class="position-relative">
                                <input type="number" step="1" class="form-control no-arrow variant_sizes"
                                    name="variant_sizes[0]" autocomplete="off" placeholder="2">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Label
                                <rf />
                            </label>
                            <div class="position-relative">
                                <input type="text" class="form-control no-arrow variant_labels"
                                    name="variant_labels[0]" autocomplete="off" placeholder="1 kg">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">MRP.
                                <rf />
                            </label>
                            <div class="position-relative">
                                <input type="number" class="form-control no-arrow variant_mrps" name="variant_mrps[0]" placeholder="123.5">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Thumbnail Image (300 x 300px)
                            </label>
                            <div class="position-relative">
                                <input class="form-control variant_thumbnail_images" type="file" name="variant_thumbnail_images[0]"
                                    accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-1 text-right">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex justify-content-end"><button data-action="remove-variant" type="button"
                                    class="btn btn-primary btn-sm btn-danger" disabled><i class="bx bx-trash"></i></button></di>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="no-variants" style="display: non">
                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <label for="codegd" class="form-label">Code
                                <rf />
                            </label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="codegd" name="code"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="uids" class="form-label">Item Size
                                <rf />
                            </label>
                            <div class="position-relative">
                                <input type="number" step="1" class="form-control no-arrow" id="uids"
                                    name="item_size" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="mrpy" class="form-label">MRP.
                                <rf />
                            </label>
                            <div class="position-relative">
                                <input class="form-control" id="mrpy" name="maximum_retail_price">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="thumzsds" class="form-label">Thumbnail Image (300 x 300px)
                            </label>
                            <div class="position-relative">
                                <input class="form-control" type="file" id="thumzsds" name="thumbnail_image"
                                    accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex bd-highlight">
                    <div class="me-auto p-2 bd-highlight"></div>
                    <div class="p-2 bd-highlight"><button type="submit" class="btn btn-success">Save</button></div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('link-styles')
    <!-- Pushed Link Styles -->
    <link href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.1/css/tom-select.bootstrap5.min.css"
        integrity="sha512-w7Qns0H5VYP5I+I0F7sZId5lsVxTH217LlLUPujdU+nLMWXtyzsRPOP3RCRWTC8HLi77L4rZpJ4agDW3QnF7cw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@push('inline-styles')
    <!-- Pushed Inline Styles -->
@endpush
@push('link-scripts')
    <!-- Pushed Link Scripts -->
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.1/js/tom-select.complete.js"
        integrity="sha512-96+GeOCMUo6K6W5zoFwGYN9dfyvJNorkKL4cv+hFVmLYx/JZS5vIxOk77GqiK0qYxnzBB+4LbWRVgu5XcIihAQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/user/js/products.new.js?v=') . config('version.user_assets') }}"></script>
@endpush
@push('inline-scripts')
    <!-- Pushed Inline Scripts -->
@endpush
