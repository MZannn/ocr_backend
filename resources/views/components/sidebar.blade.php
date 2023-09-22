<div class="sidebar">
    <div class="scrollbar-inner sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img src="{{ asset('assets/img/profile.jpg') }}">
            </div>
            <div class="info">
                <a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                    <span>
                        Hizrian
                        <span class="user-level">Administrator</span>
                        <span class="caret"></span>
                    </span>
                </a>
                <div class="clearfix"></div>

                <div class="collapse in" id="collapseExample" aria-expanded="true" style="">
                    <ul class="nav">
                        <li>
                            <a href="#profile">
                                <span class="link-collapse">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#edit">
                                <span class="link-collapse">Edit Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#settings">
                                <span class="link-collapse">Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item {{ request()->is(['/'])  ? 'active' : ''}}">
                <a href="{{ route('home') }}">
                    <i class="la la-dashboard"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item {{ request()->is(['security','security/*']) ? 'active' : '' }}">
                <a href="{{ route('security.index') }}">
                    <i class="la la-table"></i>
                    <p>Master Security</p>
                </a>
            </li>
            <li class="nav-item {{ request()->is(['resident','resident/*']) ? 'active' : '' }}">
                <a href="{{ route('resident.index') }}">
                    <i class="la la-keyboard-o"></i>
                    <p>Master Resident</p>
                </a>
            </li>
            <li class="nav-item {{ request()->is(['visitor','visitor/*']) ? 'active' : '' }}">
                <a href="{{ route('visitor.index') }}">
                    <i class="la la-th"></i>
                    <p>History Pengunjung</p>
                </a>
            </li>
        </ul>
    </div>
</div>
