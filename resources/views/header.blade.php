<header class="site-header">
    <div class="container">
        <nav class="navbar">
            <div class="navbar__brand">
                <a href="/">Employee Roster</a>
            </div>
            <div class="overlay"></div>
            <div class="navbar__container">
                <ul class="navbar__nav">
                    @if (!auth()->user()->isStaff())
                        <li class="is-active">
                            <a href="{{route('index')}}">
                                <div class="nav-item__icon">
                                    <img alt="alt text" src="{!! asset('image/roster.svg') !!}">
                                </div>
                                Roster
                            </a>
                        </li>
                        <li>
                            <div class="nav-item__icon">
                                <img alt="alt text" src="{!! asset('image/staff.svg') !!}">
                            </div>
                            <a href="{{route('userList')}}">Staff</a>
                        </li>
                        <li>
                            <div class="nav-item__icon">
                                <img alt="alt text" src="{!! asset('image/payroll.svg') !!}">
                            </div>
                            <ahref="#">Payroll</a>
                        </li>
                    @endif
                </ul>
                <div class="navbar__user">
                    <button class="navbar__user__button">
                        <div class="navbar__user__icon">
                            <img alt="alt text" src="{!! asset('image/user.svg') !!}">
                        </div>
                    </button>
                    <div class="navbar__user__info">
                        <div class="navbar__user__name">{{auth()->user()->username}}</div>
                        <div class="navbar__user__role">Nhân viên</div>
                    </div>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu__header">
                            <div class="dropdown-menu__header__image"></div>
                            <div class="dropdown-menu__header__content">
                                <div class="dropdown-menu__header__icon">
                                    <img alt="alt text" src="{!! asset('image/user.svg') !!}">
                                </div>
                                <div class="dropdown-menu__header__info">
                                    <div class="dropdown-menu__header__name">{{auth()->user()->username}}</div>
                                    <div class="dropdown-menu__header__role">Nhân viên</div>
                                </div>
                                <div class="dropdown-menu__header__logout">
                                    <a class="btn btn-dark btn-radius--50 btn-shadow" href="#">Logout</a>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-menu__content">
                            <ul class="dropdown-menu__content__nav">
                                <li class="dropdown-menu__content__nav__header">
                                    activity
                                </li>
                                <li>
                                    <a href="#">Change password</a>
                                </li>
                                <li>
                                    <a href="#">View profile</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="navbar__toggler">
                <div class="navbar__line"></div>
                <div class="navbar__line"></div>
                <div class="navbar__line"></div>
            </div>
        </nav>
    </div>
</header>