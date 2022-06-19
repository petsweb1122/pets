<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">All User's Information</h3>
    </div>
    <div class="box-body  table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>S.No</th>
                <th>User Id</th>
                <th>Full Name</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            @if (!empty($users))
                @foreach ($users as $user)
                    <tr>
                        <td>{{ ++$start_sno }}</td>
                        <td>{{ $user->user_id }}</td>
                        <td>{{ $user->name }} {{ $user->last_name }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <i class="fa fa-trash text-red" data-id="{{ $user->user_id }}" title="Delete"
                                data-toggle="modal" data-target="#modal-default"
                                onclick="updateActionValues(this, 'deleted')"></i>
                            <a href="{{ url("/admin/users/$user->user_id/update") }}">
                                <i class="fa fa-edit text-orange" title="Update user"></i>
                            </a>
                            <a href="{{ url("/admin/users/$user->user_id/details") }}">
                                <i class="fa fa-eye text-green" title="View user"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-info text-center">Sorry! No data found</td>
                </tr>
            @endif
        </table>
    </div>
    @include('common.paginations')

</div>
