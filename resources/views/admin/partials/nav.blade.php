<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">

    <div class="navbar-header">
        <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
                data-toggle="menubar">
            <span class="sr-only">Toggle navigation</span>
            <span class="hamburger-bar"></span>
        </button>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
                data-toggle="collapse">
            <i class="icon wb-more-horizontal" aria-hidden="true"></i>
        </button>
        <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
            <a href="{{ route('admin.dashboard') }}"><img class="navbar-brand-logo" src="/assets/images/logo.png" title="Remark"></a>
            <span class="navbar-brand-text hidden-xs-down"> sPhoton Admin</span>
        </div>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search"
                data-toggle="collapse">
            <span class="sr-only">Toggle Search</span>
            <i class="icon wb-search" aria-hidden="true"></i>
        </button>
    </div>

    <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        .
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
            <!-- Navbar Toolbar -->
            <ul class="nav navbar-toolbar">
                <li class="nav-item hidden-float" id="toggleMenubar">
                    <a class="nav-link" data-toggle="menubar" href="#" role="button">
                        <i class="icon hamburger hamburger-arrow-left">
                            <span class="sr-only">Toggle menubar</span>
                            <span class="hamburger-bar"></span>
                        </i>
                    </a>
                </li>
                <li class="nav-item hidden-sm-down" id="toggleFullscreen">
                    <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                        <span class="sr-only">Toggle fullscreen</span>
                    </a>
                </li>
                <li class="nav-item hidden-float">
                    <a class="nav-link icon wb-search" data-toggle="collapse" href="#" data-target="#site-navbar-search"
                       role="button">
                        <span class="sr-only">Toggle Search</span>
                    </a>
                </li>
                <li class="nav-item dropdown dropdown-fw dropdown-mega">
{{--                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="fade"--}}
{{--                       role="button">Mega <i class="icon wb-chevron-down-mini" aria-hidden="true"></i></a>--}}
{{--                    <div class="dropdown-menu" role="menu">--}}
{{--                        <div class="mega-content">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <h5>UI Kit</h5>--}}
{{--                                    <ul class="blocks-2">--}}
{{--                                        <li class="mega-menu m-0">--}}
{{--                                            <ul class="list-icons">--}}
{{--                                                <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>--}}
{{--                                                    <a--}}
{{--                                                        href="advanced/animation.html">Animation</a>--}}
{{--                                                </li>--}}
{{--                                                <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>--}}
{{--                                                    <a--}}
{{--                                                        href="uikit/buttons.html">Buttons</a>--}}
{{--                                                </li>--}}
{{--                                                <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>--}}
{{--                                                    <a--}}
{{--                                                        href="uikit/colors.html">Colors</a>--}}
{{--                                                </li>--}}
{{--                                                <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>--}}
{{--                                                    <a--}}
{{--                                                        href="uikit/dropdowns.html">Dropdowns</a>--}}
{{--                                                </li>--}}
{{--                                                <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>--}}
{{--                                                    <a--}}
{{--                                                        href="uikit/icons.html">Icons</a>--}}
{{--                                                </li>--}}
{{--                                                <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>--}}
{{--                                                    <a--}}
{{--                                                        href="advanced/lightbox.html">Lightbox</a>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
{{--                                        </li>--}}
{{--                                        <li class="mega-menu m-0">--}}
{{--                                            <ul class="list-icons">--}}
{{--                                                <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>--}}
{{--                                                    <a--}}
{{--                                                        href="uikit/modals.html">Modals</a>--}}
{{--                                                </li>--}}
{{--                                                <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>--}}
{{--                                                    <a--}}
{{--                                                        href="uikit/panel-structure.html">Panels</a>--}}
{{--                                                </li>--}}
{{--                                                <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>--}}
{{--                                                    <a--}}
{{--                                                        href="structure/overlay.html">Overlay</a>--}}
{{--                                                </li>--}}
{{--                                                <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>--}}
{{--                                                    <a--}}
{{--                                                        href="uikit/tooltip-popover.html ">Tooltips</a>--}}
{{--                                                </li>--}}
{{--                                                <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>--}}
{{--                                                    <a--}}
{{--                                                        href="advanced/scrollable.html">Scrollable</a>--}}
{{--                                                </li>--}}
{{--                                                <li><i class="wb-chevron-right-mini" aria-hidden="true"></i>--}}
{{--                                                    <a--}}
{{--                                                        href="uikit/typography.html">Typography</a>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <h5>Media--}}
{{--                                        <span class="badge badge-pill badge-success">4</span>--}}
{{--                                    </h5>--}}
{{--                                    <ul class="blocks-3">--}}
{{--                                        <li>--}}
{{--                                            <a class="thumbnail m-0" href="javascript:void(0)">--}}
{{--                                                <img class="w-full" src="/assets/global/photos/placeholder.png"--}}
{{--                                                     alt="..."/>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a class="thumbnail m-0" href="javascript:void(0)">--}}
{{--                                                <img class="w-full" src="/assets/global/photos/placeholder.png"--}}
{{--                                                     alt="..."/>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a class="thumbnail m-0" href="javascript:void(0)">--}}
{{--                                                <img class="w-full" src="/assets/global/photos/placeholder.png"--}}
{{--                                                     alt="..."/>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a class="thumbnail m-0" href="javascript:void(0)">--}}
{{--                                                <img class="w-full" src="/assets/global/photos/placeholder.png"--}}
{{--                                                     alt="..."/>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a class="thumbnail m-0" href="javascript:void(0)">--}}
{{--                                                <img class="w-full" src="/assets/global/photos/placeholder.png"--}}
{{--                                                     alt="..."/>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a class="thumbnail m-0" href="javascript:void(0)">--}}
{{--                                                <img class="w-full" src="/assets/global/photos/placeholder.png"--}}
{{--                                                     alt="..."/>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <h5 class="mb-0">Accordion</h5>--}}
{{--                                    <!-- Accordion -->--}}
{{--                                    <div class="panel-group panel-group-simple" id="siteMegaAccordion"--}}
{{--                                         aria-multiselectable="true"--}}
{{--                                         role="tablist">--}}
{{--                                        <div class="panel">--}}
{{--                                            <div class="panel-heading" id="siteMegaAccordionHeadingOne" role="tab">--}}
{{--                                                <a class="panel-title" data-toggle="collapse"--}}
{{--                                                   href="#siteMegaCollapseOne" data-parent="#siteMegaAccordion"--}}
{{--                                                   aria-expanded="false" aria-controls="siteMegaCollapseOne">--}}
{{--                                                    Collapsible Group Item #1--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="panel-collapse collapse" id="siteMegaCollapseOne"--}}
{{--                                                 aria-labelledby="siteMegaAccordionHeadingOne"--}}
{{--                                                 role="tabpanel">--}}
{{--                                                <div class="panel-body">--}}
{{--                                                    De moveat laudatur vestra parum doloribus labitur sentire partes,--}}
{{--                                                    eripuit praesenti--}}
{{--                                                    congressus ostendit alienae, voluptati ornateque accusamus--}}
{{--                                                    clamat reperietur convicia albucius.--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="panel">--}}
{{--                                            <div class="panel-heading" id="siteMegaAccordionHeadingTwo" role="tab">--}}
{{--                                                <a class="panel-title collapsed" data-toggle="collapse"--}}
{{--                                                   href="#siteMegaCollapseTwo"--}}
{{--                                                   data-parent="#siteMegaAccordion" aria-expanded="false"--}}
{{--                                                   aria-controls="siteMegaCollapseTwo">--}}
{{--                                                    Collapsible Group Item #2--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="panel-collapse collapse" id="siteMegaCollapseTwo"--}}
{{--                                                 aria-labelledby="siteMegaAccordionHeadingTwo"--}}
{{--                                                 role="tabpanel">--}}
{{--                                                <div class="panel-body">--}}
{{--                                                    Praestabiliorem. Pellat excruciant legantur ullum leniter vacare--}}
{{--                                                    foris voluptate--}}
{{--                                                    loco ignavi, credo videretur multoque choro fatemur mortis--}}
{{--                                                    animus adoptionem, bello statuat expediunt naturales.--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="panel">--}}
{{--                                            <div class="panel-heading" id="siteMegaAccordionHeadingThree" role="tab">--}}
{{--                                                <a class="panel-title collapsed" data-toggle="collapse"--}}
{{--                                                   href="#siteMegaCollapseThree"--}}
{{--                                                   data-parent="#siteMegaAccordion" aria-expanded="false"--}}
{{--                                                   aria-controls="siteMegaCollapseThree">--}}
{{--                                                    Collapsible Group Item #3--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="panel-collapse collapse" id="siteMegaCollapseThree"--}}
{{--                                                 aria-labelledby="siteMegaAccordionHeadingThree"--}}
{{--                                                 role="tabpanel">--}}
{{--                                                <div class="panel-body">--}}
{{--                                                    Horum, antiquitate perciperet d conspectum locus obruamus animumque--}}
{{--                                                    perspici probabis--}}
{{--                                                    suscipere. Desiderat magnum, contenta poena desiderant--}}
{{--                                                    concederetur menandri damna disputandum corporum.--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!-- End Accordion -->--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </li>
            </ul>
            <!-- End Navbar Toolbar -->

            <!-- Navbar Toolbar Right -->
            <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" data-animation="scale-up"
                       aria-expanded="false" role="button">
                        <span class="flag-icon flag-icon-us"></span>
                    </a>
{{--                    <div class="dropdown-menu" role="menu">--}}
{{--                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem">--}}
{{--                            <span class="flag-icon flag-icon-gb"></span> English</a>--}}
{{--                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem">--}}
{{--                            <span class="flag-icon flag-icon-fr"></span> French</a>--}}
{{--                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem">--}}
{{--                            <span class="flag-icon flag-icon-cn"></span> Chinese</a>--}}
{{--                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem">--}}
{{--                            <span class="flag-icon flag-icon-de"></span> German</a>--}}
{{--                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem">--}}
{{--                            <span class="flag-icon flag-icon-nl"></span> Dutch</a>--}}
{{--                    </div>--}}
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                       data-animation="scale-up" role="button">
                <span class="avatar avatar-online">
{{--                  <img src="/assets/global/portraits/5.jpg" alt="...">--}}
                  <img src="data:image/png;base64,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" alt="...">
                  <i></i>
                </span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-user"
                                                                                              aria-hidden="true"></i>
                            Profile</a>
                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-payment"
                                                                                              aria-hidden="true"></i>
                            Billing</a>
                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-settings"
                                                                                              aria-hidden="true"></i>
                            Settings</a>
                        <div class="dropdown-divider" role="presentation"></div>
                        <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" role="menuitem"><i class="icon wb-power"
                            aria-hidden="true" ></i>
                            Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" title="Notifications"
                       aria-expanded="false" data-animation="scale-up" role="button">
                        <i class="icon wb-bell" aria-hidden="true"></i>
                        <span class="badge badge-pill badge-danger up">5</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                        <div class="dropdown-menu-header">
                            <h5>NOTIFICATIONS</h5>
                            <span class="badge badge-round badge-danger">New 5</span>
                        </div>

                        <div class="list-group">
                            <div data-role="container">
                                <div data-role="content">
                                    <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <div class="media">
                                            <div class="pr-10">
                                                <i class="icon wb-order bg-red-600 white icon-circle"
                                                   aria-hidden="true"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">A new order has been placed</h6>
                                                <time class="media-meta" datetime="2018-06-12T20:50:48+08:00">5 hours
                                                    ago
                                                </time>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <div class="media">
                                            <div class="pr-10">
                                                <i class="icon wb-user bg-green-600 white icon-circle"
                                                   aria-hidden="true"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Completed the task</h6>
                                                <time class="media-meta" datetime="2018-06-11T18:29:20+08:00">2 days
                                                    ago
                                                </time>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <div class="media">
                                            <div class="pr-10">
                                                <i class="icon wb-settings bg-red-600 white icon-circle"
                                                   aria-hidden="true"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Settings updated</h6>
                                                <time class="media-meta" datetime="2018-06-11T14:05:00+08:00">2 days
                                                    ago
                                                </time>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <div class="media">
                                            <div class="pr-10">
                                                <i class="icon wb-calendar bg-blue-600 white icon-circle"
                                                   aria-hidden="true"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Event started</h6>
                                                <time class="media-meta" datetime="2018-06-10T13:50:18+08:00">3 days
                                                    ago
                                                </time>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <div class="media">
                                            <div class="pr-10">
                                                <i class="icon wb-chat bg-orange-600 white icon-circle"
                                                   aria-hidden="true"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Message received</h6>
                                                <time class="media-meta" datetime="2018-06-10T12:34:48+08:00">3 days
                                                    ago
                                                </time>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-menu-footer">
                            <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                                <i class="icon wb-settings" aria-hidden="true"></i>
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                                All notifications
                            </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" title="Messages"
                       aria-expanded="false" data-animation="scale-up" role="button">
                        <i class="icon wb-envelope" aria-hidden="true"></i>
                        <span class="badge badge-pill badge-info up">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                        <div class="dropdown-menu-header" role="presentation">
                            <h5>MESSAGES</h5>
                            <span class="badge badge-round badge-info">New 3</span>
                        </div>

                        <div class="list-group" role="presentation">
                            <div data-role="container">
                                <div data-role="content">
                                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                                        <div class="media">
                                            <div class="pr-10">
                            <span class="avatar avatar-sm avatar-online">
                              <img src="/assets/global/portraits/2.jpg" alt="..."/>
                              <i></i>
                            </span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Mary Adams</h6>
                                                <div class="media-meta">
                                                    <time datetime="2018-06-17T20:22:05+08:00">30 minutes ago</time>
                                                </div>
                                                <div class="media-detail">Anyways, i would like just do it</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                                        <div class="media">
                                            <div class="pr-10">
                            <span class="avatar avatar-sm avatar-off">
                              <img src="/assets/global/portraits/3.jpg" alt="..."/>
                              <i></i>
                            </span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Caleb Richards</h6>
                                                <div class="media-meta">
                                                    <time datetime="2018-06-17T12:30:30+08:00">12 hours ago</time>
                                                </div>
                                                <div class="media-detail">I checheck the document. But there seems</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                                        <div class="media">
                                            <div class="pr-10">
                            <span class="avatar avatar-sm avatar-busy">
                              <img src="/assets/global/portraits/4.jpg" alt="..."/>
                              <i></i>
                            </span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">June Lane</h6>
                                                <div class="media-meta">
                                                    <time datetime="2018-06-16T18:38:40+08:00">2 days ago</time>
                                                </div>
                                                <div class="media-detail">Lorem ipsum Id consectetur et minim</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                                        <div class="media">
                                            <div class="pr-10">
                            <span class="avatar avatar-sm avatar-away">
                              <img src="/assets/global/portraits/5.jpg" alt="..."/>
                              <i></i>
                            </span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Edward Fletcher</h6>
                                                <div class="media-meta">
                                                    <time datetime="2018-06-15T20:34:48+08:00">3 days ago</time>
                                                </div>
                                                <div class="media-detail">Dolor et irure cupidatat commodo nostrud
                                                    nostrud.
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-menu-footer" role="presentation">
                            <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                                <i class="icon wb-settings" aria-hidden="true"></i>
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                                See all messages
                            </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item" id="toggleChat">
                    <a class="nav-link" data-toggle="site-sidebar" href="javascript:void(0)" title="Chat"
                       data-url="site-sidebar.tpl">
                        <i class="icon wb-chat" aria-hidden="true"></i>
                    </a>
                </li>
            </ul>
            <!-- End Navbar Toolbar Right -->
        </div>
        <!-- End Navbar Collapse -->

        <!-- Site Navbar Seach -->
        <div class="collapse navbar-search-overlap" id="site-navbar-search">
            <form role="search">
                <div class="form-group">
                    <div class="input-search">
                        <i class="input-search-icon wb-search" aria-hidden="true"></i>
                        <input type="text" class="form-control" name="site-search" placeholder="Search...">
                        <button type="button" class="input-search-close icon wb-close" data-target="#site-navbar-search"
                                data-toggle="collapse" aria-label="Close"></button>
                    </div>
                </div>
            </form>
        </div>
        <!-- End Site Navbar Seach -->
    </div>
</nav>
