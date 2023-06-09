
<!-- Page -->
{{--    <div class="page">--}}
{{--        <div class="page-header">--}}
{{--            <h1 class="page-title">Danh sách người dùng</h1>--}}
{{--            <ol class="breadcrumb">--}}
{{--                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>--}}
{{--                <li class="breadcrumb-item"><a href="javascript:void(0)">Danh sách người dùng</a></li>--}}
{{--            </ol>--}}
{{--            <div class="page-header-actions">--}}
{{--                <a class="btn btn-sm btn-default btn-outline btn-round" href="http://fun.sphoton.com"--}}
{{--                   target="_blank">--}}
{{--                    <i class="icon wb-link" aria-hidden="true"></i>--}}
{{--                    <span class="hidden-sm-down">fun website</span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="page-content">--}}
{{--            <!-- Panel Basic -->--}}
{{--            <div class="panel">--}}
{{--                <header class="panel-heading">--}}
{{--                    <div class="panel-actions"></div>--}}
{{--                    <h3 class="panel-title">Toàn bộ người dùng</h3>--}}
{{--                </header>--}}
{{--                <div class="panel-body">--}}
{{--                    <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>Name</th>--}}
{{--                            <th>Email</th>--}}
{{--                            <th>Post</th>--}}
{{--                            <th>Upvote</th>--}}
{{--                            <th>Downvote</th>--}}
{{--                            <th>Status</th>--}}
{{--                            <th>Last login</th>--}}
{{--                            <th></th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @if ($users->status = 'banned')--}}
{{--                            @foreach ($users->reverse() as $user)--}}
{{--                                <tr>--}}
{{--                                    <td>{{$user->name}}</td>--}}
{{--                                    <td>{{$user->email}}</td>--}}
{{--                                    <td>{{isset($user->posts) ? $user->posts->count() : 0}}</td>--}}
{{--                                    <td>{{$user->posts()->sum('upvote')}}</td>--}}
{{--                                    <td>{{$user->posts()->sum('downvote')}}</td>--}}

{{--                                    <td><button class="item-button btn btn-danger">{{$user->status}}</button></td>--}}
{{--                                    <td>{{$user->last_login_at}}</td>--}}
{{--                                    <form action="{{ route('admin.restore',$user->id)}}" method="get">--}}
{{--                                        @csrf--}}
{{--                                        <td>--}}
{{--                                            <button type="submit" class="item-button btn btn-sm btn-success">Restore</button>--}}
{{--                                        </td>--}}
{{--                                    </form>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--                {!! $users->links() !!}--}}
{{--            </div>--}}
{{--            <!-- End Panel Basic -->--}}
{{--        </div>--}}
{{--    </div>--}}
<!-- End Page -->
{{--duyyyyyyyyyyy--}}



<div class="card">
    <div class="card-body pd-0">
        <h4 class="card-title mb-0">Danh sách người dùng bị cấm</h4>
        <div class="row">
            <div class="col-md-4 user_role"></div>
            <div class="col-md-4 user_plan"></div>
            <div class="col-md-4 user_status"></div>
        </div>
    </div>
    <div class="card-datatable table-responsive pt-0">
        <table class="user-list-table table">
            <thead class="table-light">
            <tr>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>POST</th>
                {{--                    <th>STATUS</th>--}}
                <th>LAST LOGIN</th>
                <th>HÀNH ĐỘNG</th>

            </tr>
            </thead>
            <tbody>

            {{--                @if ($users->status = 'banned')--}}
            @foreach ($users->reverse() as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{isset($user->posts) ? $user->posts->count() : 0}}</td>
                    {{--                                    <td>{{$user->posts()->sum('upvote')}}</td>--}}
                    {{--                                    <td>{{$user->posts()->sum('downvote')}}</td>--}}

                    {{--                        <td>--}}
                    {{--                            <button class="item-button btn btn-danger">{{$user->status}}</button>--}}
                    {{--                        </td>--}}
                    <td>{{$user->last_login_at}}</td>
                    <form action="{{ route('admin.restore',$user->id)}}" method="get">
                        @csrf
                        <td>
                            <button type="submit" class="item-button btn btn-sm btn-success">Restore</button>
                        </td>
                    </form>
                </tr>
            @endforeach
            {{--                        @endif--}}

            </tbody>
        </table>
    </div>
    {!! $users->links('vendor.pagination.bootstrap-4') !!}

</div>


<style>

</style>


<script src="/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
<script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
<script src="/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
<script>
    var dtUserTable = $('.user-list-table');

    dtUserTable.DataTable({
        paging: false,
        dom:
            '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
            '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
            '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
            '>t' +
            '<"d-flex justify-content-between mx-2 row mb-1"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',

        language: {
            sLengthMenu: 'Show _MENU_',
            search: 'Tìm kiếm',
            paginate: {
                // remove previous & next text from pagination
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        },
        // Buttons with Dropdown
        buttons: [],

    });
</script>

