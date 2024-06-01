@extends('layouts.admin.base')
@section('title', 'All Users | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Users</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-header px-0 d-flex justify-content-between align-items-center">
                    <h6 class="card-title">All Users</h6>
                    <a class="btn btn-primary" href="{{ route('admin.users.create') }}" role="button">Add
                        User</a>
                </div>
                <div class="filter">
                    <form action="{{ route('admin.users.index') }}" class="filter-form row g-3">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="name" value="{{ request()->get('name') ? request()->get('name') : '' }}" placeholder="Name" />
                            <input type="text" class="form-control" name="email" value="{{ request()->get('email') ? request()->get('email') : '' }}" placeholder="Email" />
                            <select class="form-select" name="role">
                                <option value="All" {{ request()->get('role') == 'All' ? 'selected' : '' }}>Select Role
                                </option>
                                <option value="user" {{ request()->get('role') == 'user' ? 'selected' : ''
                                    }}>User</option>
                                <option value="merchant" {{ request()->get('role') == 'merchant' ? 'selected' : ''
                                    }}>Merchant</option>
                                <option value="admin" {{ request()->get('role') == 'admin' ? 'selected' : ''
                                    }}>Admin</option>
                            </select>
                            <select class="form-select" name="status">
                                <option value="All" {{ request()->get('status') == 'All' ? 'selected' : '' }}>Select Status
                                </option>
                                <option value="active" {{ request()->get('status') == 'active' ? 'selected' : ''
                                    }}>Active</option>
                                <option value="suspend" {{ request()->get('status') == 'suspend' ? 'selected' : ''
                                    }}>Suspend</option>
                                <option value="deactive" {{ request()->get('status') == 'deactive' ? 'selected' : ''
                                    }}>Deactive</option>
                            </select>
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive pt-3">
                    <table class="table table-striped table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 30%;">Name</th>
                                <th style="width: 20%;">Email</th>
                                <th style="width: 15%;">Phone</th>
                                <th style="width: 15%;">Role</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($users) && $users->count() > 0)
                            @foreach($users as $key => $user)
                            <tr>
                                <td>{{ $users->currentpage() * $users->perpage() - $users->perpage() + ++$key }}</td>
                                <td>
                                    {{ $user->first_name . ' ' . $user->last_name }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    {{ $user->phone }}
                                </td>
                                <td>
                                    @if($user->is_merchant)
                                    <span class="badge rounded-pill bg-primary">Merchant</span>
                                    @elseif($user->is_admin)
                                    <span class="badge rounded-pill bg-primary">Admin</span>
                                    @else
                                    <span class="badge rounded-pill bg-primary">User</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->status == 'active')
                                    <span class="badge rounded-pill bg-primary">Active</span>
                                    @elseif($user->status == 'suspend')
                                    <span class="badge rounded-pill bg-warning">Suspend</span>
                                    @else
                                    <span class="badge rounded-pill bg-warning">Deactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <div class="edit-btn">
                                            <a class="btn btn-sm btn-primary" href="{{ route('admin.users.edit', $user->id) }}" role="button">Edit</a>
                                        </div>
                                        <div class="delete-btn ms-2">
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete?');" role="button">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="text-center">
                                <td colspan="7">No Result Found!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="pagination mt-2">
                    <div class="d-flex justify-content-center">
                        {{ $users->appends(request()->query())->links('layouts.admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection