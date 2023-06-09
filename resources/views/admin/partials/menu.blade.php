<div class="site-menubar">
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu" data-plugin="menu">
                    <li class="site-menu-category">Quản lí người dùng</li>
                    <li class="site-menu-item">
                        <a href="{{ route('admin.active_user') }}">
                            <i class="site-menu-icon wb-users" aria-hidden="true"></i>
                            <span class="site-menu-title">Danh sách người dùng</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a href="{{ route('admin.banned') }}">
                            <i class="site-menu-icon wb-minus-circle" aria-hidden="true"></i>
                            <span class="site-menu-title">Người dùng bị cấm</span>
                        </a>
                    </li>
                    <!-- quản lý nội dung -->
                    <li class="site-menu-category">Quản lí nội dung</li>
                    <li class="site-menu-item">
                        <a href="{{route('admin.posts.waiting')}}">
                            <i class="site-menu-icon wb-users" aria-hidden="true"></i>
                            <span class="site-menu-title">Bài chưa duyệt</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a href="{{ route('admin.showpost') }}">
                            <i class="site-menu-icon wb-file" aria-hidden="true"></i>
                            <span class="site-menu-title">Tất cả bài viết</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a href="{{ route('admin.hide_post') }}">
                            <i class="site-menu-icon wb-minus-circle" aria-hidden="true"></i>
                            <span class="site-menu-title">Bài bị ẩn</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a href="{{ route('admin.deletedpost') }}">
                            <i class="site-menu-icon wb-trash" aria-hidden="true"></i>
                            <span class="site-menu-title">Bài bị xóa</span>
                        </a>
                    </li>
                    <!-- phân tích thống kê -->
                    <li class="site-menu-category">Phân tích thống kê</li>
{{--                    <li class="site-menu-item">--}}
{{--                        <a>--}}
{{--                            <i class="site-menu-icon wb-users" aria-hidden="true"></i>--}}
{{--                            <span class="site-menu-title">Danh sách người dùng</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="site-menu-item">--}}
{{--                        <a>--}}
{{--                            <i class="site-menu-icon wb-stop" aria-hidden="true"></i>--}}
{{--                            <span class="site-menu-title">Người dùng bị cấm</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                </ul>
            </div>
        </div>
    </div>

    <div class="site-menubar-footer">
        <a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip"
           data-original-title="Settings">
            <span class="icon wb-settings" aria-hidden="true"></span>
        </a>
        <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock">
            <span class="icon wb-eye-close" aria-hidden="true"></span>
        </a>
        <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
            <span class="icon wb-power" aria-hidden="true"></span>
        </a>
    </div>
</div>
