<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <form action="{{route('staff.logout')}}" method="post">
                {!! csrf_field() !!}
                <button class="nav-link" type="submit" style="background: unset;border: unset;">
                    Logout
                </button>
            </form>
        </li>
    </ul>
</nav>
