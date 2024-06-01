@extends('layouts.admin.base')
@section('title', 'Edit Category Serial | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Category Serial</li>
    </ol>
</nav>
<form action="{{ route('admin.category_serial.update', $section) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="row g-3">
        <div class="col-md-9">
            <div class="card my-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Edit Category Serial</h6>
                </div>
                <div class="card-body category-serial p-2">
                    <div class="row my-3">
                        <div class="col-md-6">
                            <h4 class="fw-bold mb-3">Active Categories</h4>

                            <ul id="active-categories" class="list-group connectedSortable">
                            @foreach($parentCategories as $parentCategory)
                                    @if(in_array($parentCategory->id, $activeCategoryIds))
                                        <li class="list-group-item" data-id="{{ $parentCategory->id }}">
                                            {{ $parentCategory->title }}
                                            <input type="hidden" name="category_ids[]" value="{{ $parentCategory->id }}">
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

                        </div>

                        <div class="col-md-6">
                            <h4 class="fw-bold mb-3">Inactive Categories</h4>

                            <ul id="inactive-categories" class="list-group connectedSortable">
                            @foreach($parentCategories as $parentCategory)
                                    @if(!in_array($parentCategory->id, $activeCategoryIds))
                                        <li class="list-group-item" data-id="{{ $parentCategory->id }}">
                                            {{ $parentCategory->title }}
                                            <input type="hidden" name="inactive_category_ids[]" value="{{ $parentCategory->id }}">
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

                        </div>
                    </div>
                    <button class="btn btn-primary py-2 px-5" type="submit">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var activeCategories = document.getElementById('active-categories');
    var inactiveCategories = document.getElementById('inactive-categories');

    if (activeCategories && inactiveCategories) {
        // Both lists exist, initialize Sortable instances
        new Sortable(activeCategories, {
            group: 'shared',
            animation: 150,
            onAdd: function (evt) {
                var draggedItem = evt.item;
                var inputField = draggedItem.querySelector('input[type="hidden"]');
                var parentList = draggedItem.parentNode;
                if (parentList.id === 'active-categories') {
                    inputField.setAttribute('name', 'category_ids[]');
                } else {
                    inputField.setAttribute('name', 'inactive_category_ids[]');
                }
            }
        });

        new Sortable(inactiveCategories, {
            group: 'shared',
            animation: 150,
            onAdd: function (evt) {
                var draggedItem = evt.item;
                var inputField = draggedItem.querySelector('input[type="hidden"]');
                var parentList = draggedItem.parentNode;
                if (parentList.id === 'active-categories') {
                    inputField.setAttribute('name', 'category_ids[]');
                } else {
                    inputField.setAttribute('name', 'inactive_category_ids[]');
                }
            }
        });
    } else {
        console.error("One or both of the lists are not available.");
    }
});
</script>
@endpush