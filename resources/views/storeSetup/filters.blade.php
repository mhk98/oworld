@extends('layouts.base')
@section('content')
<!-- Store setup logo start -->
<div class="store-setup-logo">
    <a href="{{ route('index') }}">
        <img src="{{ asset('static/images/logo.png') }}" alt="Logo">
    </a>
</div>
<!-- Store setup logo end -->

<!-- Store setup part start -->
<div class="store-setup-container">
    <div class="store-details-title">
        <h2>Store Details</h2>
    </div>

    <div class="setup-filters">
        <form action="{{ route('merchant.filter') }}" method="post" enctype="multipart/form-data" id="filterForm">
            @csrf

            <div class="px-5 additional-filters">
                <h3 class="additional-filters-title text-start pb-5">Additional Filters <span>(optional)</span></h6>


                    @if(count(array_intersect([1, 2, 3, 6, 8, 9, 10, 11, 12], $store->mainCategories->pluck('id')->toArray())) > 0)
                    <div class="row border-bottom mb-3 pb-4">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="pre_order" value="yes" id="pre_order" checked>
                                <label class="form-check-label" for="pre_order">Pre-order</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="in_stock" value="yes" id="in_stock" checked>
                                <label class="form-check-label" for="in_stock">In Stock</label>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row border-bottom mb-3 pb-4">
                        @if(in_array(8, $store->mainCategories->pluck('id')->toArray()))
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="organic" value="yes" id="organic" checked>
                                <label class="form-check-label" for="organic">Organic</label>
                            </div>
                        </div>
                        @endif

                        @if(!in_array(4, $store->mainCategories->pluck('id')->toArray()) && !in_array(12, $store->mainCategories->pluck('id')->toArray()))
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="home_delivery" value="yes" id="home_delivery" checked>
                                <label class="form-check-label" for="home_delivery">Home delivery</label>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if(count(array_intersect([1, 2, 5, 7], $store->mainCategories->pluck('id')->toArray())) > 0)
                    <div class="row border-bottom mb-3 pb-4">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="men" value="yes" id="men" checked>
                                <label class="form-check-label" for="men">Men</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="women" value="yes" id="women" checked>
                                <label class="form-check-label" for="women">Women</label>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(count(array_intersect([1, 2, 3, 6, 7, 8, 9, 11], $store->mainCategories->pluck('id')->toArray())) > 0)
                    <div class="row border-bottom mb-3 pb-4">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="imported" value="yes" id="imported" checked>
                                <label class="form-check-label" for="imported">Imported</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="local" value="yes" id="local" checked>
                                <label class="form-check-label" for="local">Local</label>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(in_array(13, $store->mainCategories->pluck('id')->toArray()))
                    <div class="row border-bottom mb-3 pb-4">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cuisine" value="yes" id="cuisine" checked>
                                <label class="form-check-label" for="cuisine">Cuisine</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="indoor" value="yes" id="indoor" checked>
                                <label class="form-check-label" for="indoor">Indoor</label>
                            </div>
                        </div>
                    </div>

                    <div class="row border-bottom mb-3 pb-2">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="outdoor" value="yes" id="outdoor" checked>
                                <label class="form-check-label" for="outdoor">Outdoor</label>
                            </div>
                        </div>
                    </div>
                    @endif
            </div>

            <div class="store-setup-btns py-5 d-flex justify-content-between">
                <a href="{{ route('merchant.externalLinks') }}" class="btn btn-default btn-back">Back</a>
                <button type="submit" class="btn btn-default btn-next">Go to your store</button>
            </div>
        </form>
    </div>

    <ul class="page-dots text-center pt-4">
        <li class="active">
            <a href="javascript:void(0);">
                <i class="fas fa-circle"></i>
            </a>
        </li>
        <li class="active">
            <a href="javascript:void(0);">
                <i class="fas fa-circle"></i>
            </a>
        </li>
        <li class="active">
            <a href="javascript:void(0);">
                <i class="fas fa-circle"></i>
            </a>
        </li>
        <li class="active">
            <a href="javascript:void(0);">
                <i class="fas fa-circle"></i>
            </a>
        </li>
    </ul>
</div>
<!-- Store setup part end -->
<style>
    .additional-filters .form-check-input {
width: 2em;
height: 2em;
}

.additional-filters .form-check-label {
    color: #545454;
font-size: 22px;
font-weight: 559;
margin-left: 15px;
}

.additional-filters .form-check-input:checked {
background-color: transparent;
border: 2px solid #737373;
}

.additional-filters .form-check-input:checked[type="checkbox"] {
background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23737373' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e");
}
</style>
@endsection