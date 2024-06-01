@extends('layouts.admin.base')
@section('title', 'Similar Words | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products_services') }}">Products & Services</a></li>
        <li class="breadcrumb-item active" aria-current="page">Similar Words</li>
    </ol>
</nav>

<div class="row g-3">
    <div class="col-md-12">
        <div class="card my-2">
            <div class="card-body p-2">
                <h4 class="mb-3">Similar Words for "{{ $word }}"</h4>

                <form action="{{ route('admin.update_similar_word', $word) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="similar_words" class="form-label">Add/Edit Similar Words</label>
                        <textarea class="form-control" id="similar_words" name="similar_words" rows="3">{{ implode(', ', $similarWords->pluck('similar')->toArray()) }}</textarea>
                        <div class="form-text">Separate similar words with commas.</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection