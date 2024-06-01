@extends('layouts.admin.base')
@section('title', 'Categories Serial | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
        <li class="breadcrumb-item active" aria-current="page">Categories Serial</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-header px-0 d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Categories Serial</h6>
                </div>
                <div class="table-responsive pt-3">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th style="width: 30%;">Section</th>
                                <th style="width: 10%;">Update Serial</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>General</td>
                                <td>
                                    <a href="{{ route('admin.category_serial.edit', 'general') }}">Update Serial</a>
                                </td>
                            </tr>

                            <tr>
                                <td>Home</td>
                                <td>
                                    <a href="{{ route('admin.category_serial.edit', 'home') }}">Update Serial</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection