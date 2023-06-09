

<div class="card">

    <div class="card-datatable table-responsive pt-0 position-relative">

        <table class="user-list-table table">
            <div style="top: 8px; gap: 181px" class="d-flex pd-0 table-title">
                <h4 class="card-title mb-0" style="padding: 20px 20px;">

                    Danh sách người dùng
                </h4>

            </div>

            <thead  class="table-light">
            <tr>
                <th style="font-family: Montserrat;font-weight: 600; font-size: 12px !important; color: #5E5873">NAME</th>
                <th style="font-family: Montserrat;font-weight: 600; font-size: 12px !important; color: #5E5873">EMAIL</th>
                <th style="font-family: Montserrat;font-weight: 600; font-size: 12px !important; color: #5E5873">POST</th>
                <th style="font-family: Montserrat;font-weight: 600; font-size: 12px !important; color: #5E5873">STATUS</th>
                <th style="font-family: Montserrat;font-weight: 600; font-size: 12px !important; color: #5E5873" >LAST LOGIN</th>
                <th style="font-family: Montserrat;font-weight: 600; font-size: 12px !important; color: #5E5873">USER IP</th>
                <th style="font-family: Montserrat;font-weight: 600; font-size: 12px !important; color: #5E5873">HÀNH ĐỘNG</th>
                <th style="font-family: Montserrat;font-weight: 600; font-size: 12px !important; color: #5E5873"></th>

            </tr>
            </thead>
            <tbody class="tours-list">

            @if ($users->status = 'active')
                @foreach ($users->reverse() as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{isset($user->posts) ? $user->posts->count() : 0}}</td>
                        {{--                                    <td>{{$user->posts()->sum('upvote')}}</td>--}}
                        {{--                                    <td>{{$user->posts()->sum('downvote')}}</td>--}}
                        <td class="box dark-box"><button class="item-button btn btn-success" type="reset">{{$user->status}}</button></td>
                        <td>{{$user->last_login_at}}</td>
                        <td>{{$user->last_login_ip}}</td>
                        <form action="{{route('admin.destroy_user',$user->id)}}" method="get">
                            @csrf
                            <td>
                                <button type="submit" class="item-button btn btn-sm btn-danger">Xóa</button>
                            </td>
                        </form>

                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    {!! $users->links('vendor.pagination.bootstrap-4') !!}
</div>

@push('css')
    <style>
        /*#DataTables_Table_0_filter{*/
        /*    margin-top: -47px;*/
        /*}*/
        #DataTables_Table_0_length{
            display: none;
        }
        .me-1{
            margin-top: -40px;
        }
        .icon {
            width: 1.4rem;
            height: 1.4rem;
            margin-right: .5rem;
        }

        .pd-0 {
            padding: 1.5rem 1.5rem 0 1.5rem;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush


@push('js')

    <script src="/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


    <script>

        var dtUserTable = $('.user-list-table');

        let table = dtUserTable.DataTable({
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
                },

            },
            // Buttons with Dropdown
            buttons: [

            ],

        });
        //filter datetime


    </script>

@endpush


