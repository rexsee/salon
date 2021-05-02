<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('staff.home')}}" class="brand-link text-sm">
        <img src="{{asset('images/logo-intro.png')}}" class="brand-image elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="{{route('staff.profile')}}" class="d-block">Hi, {{auth()->user()->name}}</a>
            </div>
        </div>

        <nav class="mt-2 mb-5">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat text-sm" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('staff.home')}}" class="nav-link nav-link-is-value">
                        <i class="nav-icon fa fa-angle-right"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(auth()->user()->group == 'FULL_CONTROL')
                <li class="nav-item">
                    <a href="{{route('staff.customer')}}" class="nav-link nav-link-is-value">
                        <i class="nav-icon fa fa-angle-right"></i>
                        <p>Customer</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('staff.customer.sms_blast')}}" class="nav-link nav-link-is-value">
                        <i class="nav-icon fa fa-angle-right"></i>
                        <p>Customer SMS Blast</p>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="{{route('staff.news')}}" class="nav-link nav-link-is-value">
                        <i class="nav-icon fa fa-angle-right"></i>
                        <p>News</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('staff.gallery')}}" class="nav-link nav-link-is-value">
                        <i class="nav-icon fa fa-angle-right"></i>
                        <p>Gallery</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('staff.about_img')}}" class="nav-link nav-link-is-value">
                        <i class="nav-icon fa fa-angle-right"></i>
                        <p>About Images</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('staff.vision_img')}}" class="nav-link nav-link-is-value">
                        <i class="nav-icon fa fa-angle-right"></i>
                        <p>Vision Images</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('staff.artwork')}}" class="nav-link nav-link-is-value">
                        <i class="nav-icon fa fa-angle-right"></i>
                        <p>Artworks</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('staff.product')}}" class="nav-link nav-link-is-value">
                        <i class="nav-icon fa fa-angle-right"></i>
                        <p>Products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('staff.service')}}" class="nav-link nav-link-is-value">
                        <i class="nav-icon fa fa-angle-right"></i>
                        <p>Services</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('staff.stylist')}}" class="nav-link nav-link-is-value">
                        <i class="nav-icon fa fa-angle-right"></i>
                        <p>Stylists</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
