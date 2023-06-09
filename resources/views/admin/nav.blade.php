<!-- Horizontal menu content-->
<div class="navbar-container main-menu-content" data-menu="menu-container">
    <!-- include ../../../includes/mixins-->
    <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="nav-item {{ \App\Helpers\RouteHelper::isActiveRoute('admin.home') }}" >
            <a class="nav-link d-flex align-items-center" href="{{  route('admin.home') }}">
                <i data-feather="home"></i>
                <span data-i18n="Dashboards">Dashboards</span>
            </a>
        </li>
        <li class=" nav-item {{ \App\Helpers\RouteHelper::isActiveRoute('admin.active_user') }}" id="nav-active-users">
            <a class="nav-link d-flex align-items-center" onclick="changeRoute('{{ route('admin.active_user')  }}','nav-active-users')">
                <i data-feather='users'></i>
                <span data-i18n="Dashboards">Danh sách người dùng</span>
            </a>
        </li>
        <li class=" nav-item {{ \App\Helpers\RouteHelper::isActiveRoute('admin.banned') }}" id="nav-banned-users">
            <a class="nav-link d-flex align-items-center" onclick="changeRoute('{{ route('admin.banned') }}','nav-banned-users')">
                <i data-feather='minus-circle'></i>
                <span data-i18n="Dashboards">Người dùng bị cấm</span>
            </a>
        </li>
        <li class=" nav-item {{ \App\Helpers\RouteHelper::isActiveRoute('admin.posts.pending') }}" id="nav-pending-posts">
            <a class="nav-link d-flex align-items-center" onclick="changeRoute('{{route('admin.posts.pending')}}','nav-pending-posts')">
                <i data-feather='users'></i>
                <span data-i18n="Dashboards">Bài viết chưa duyệt</span>
            </a>
        </li>
        <li class=" nav-item {{ \App\Helpers\RouteHelper::isActiveRoute('admin.showpost') }}" id="nav-all-posts">
            <a class="nav-link d-flex align-items-center" onclick="changeRoute('{{ route('admin.showpost') }}','nav-all-posts')" href="{{ route('admin.showpost') }}">
                <i data-feather='file-text'></i>
                <span data-i18n="Dashboards">Tất cả các bài viết</span>
            </a>
        </li>
        <li class=" nav-item {{ \App\Helpers\RouteHelper::isActiveRoute('admin.hide_post') }}" id="nav-hidden-posts">
            <a class="nav-link d-flex align-items-center" onclick="changeRoute('{{ route('admin.hide_post') }}','nav-hidden-posts')">
                <i data-feather='minus-square'></i>
                <span data-i18n="Dashboards">Bài viết bị ẩn </span>
            </a>
        </li>
        <li class=" nav-item {{ \App\Helpers\RouteHelper::isActiveRoute('admin.posts.deleted') }}" id="nav-deleted-posts">
            <a class="nav-link d-flex align-items-center" onclick="changeRoute('{{ route('admin.posts.deleted') }}','nav-deleted-posts')">
                <i data-feather='trash-2'></i>
                <span data-i18n="Dashboards">Bài viết bị xóa </span>
            </a>
        </li>
    </ul>
</div>
