<nav class="side-nav">
    <ul>
        <li>
            <a href="{{ route('dashboard') }}" class="side-menu {{ request()->routeIs('dashboard') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                <div class="side-menu__title">
                    Dashboard
                </div>
            </a>
        </li>
        <li>
            <a href="javascript:;"
                class="side-menu {{ request()->routeIs('category.index') || request()->routeIs('category.createOrEdit') ? 'side-menu--active side-menu--open' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="network"></i> </div>
                <div class="side-menu__title">
                    Category
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="{{ request()->routeIs('category.index') || request()->routeIs('category.createOrEdit') ? ' side-menu__sub-open' : '' }}">
                <li>
                    <a href="{{ route('category.createOrEdit') }}" class="side-menu {{ request()->routeIs('category.createOrEdit') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="plus-square"></i> </div>
                        <div class="side-menu__title"> Add Category </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('category.index') }}" class="side-menu {{ request()->routeIs('category.index') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="clipboard-list"></i> </div>
                        <div class="side-menu__title"> List </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;"
                class="side-menu {{ request()->routeIs('binaural-beats.index') || request()->routeIs('binaural-beats.createOrEdit') ? 'side-menu--active side-menu--open' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                <div class="side-menu__title">
                    Binaural Beats
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="{{ request()->routeIs('binaural-beats.index') || request()->routeIs('binaural-beats.createOrEdit') ? ' side-menu__sub-open' : '' }}">
                <li>
                    <a href="{{ route('binaural-beats.createOrEdit') }}" class="side-menu {{ request()->routeIs('binaural-beats.createOrEdit') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="plus-square"></i> </div>
                        <div class="side-menu__title"> Add Binaural Beats </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('binaural-beats.index') }}" class="side-menu {{ request()->routeIs('binaural-beats.index') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="clipboard-list"></i> </div>
                        <div class="side-menu__title"> List </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;"
                class="side-menu {{ request()->routeIs('background-audio.index') || request()->routeIs('background-audio.createOrEdit')? 'side-menu--active side-menu--open' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="music"></i> </div>
                <div class="side-menu__title">
                    Background Audio
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="{{ request()->routeIs('background-audio.index') || request()->routeIs('background-audio.createOrEdit') ? ' side-menu__sub-open' : '' }}">

                <li>
                    <a href="{{ route('background-audio.createOrEdit') }}" class="side-menu {{ request()->routeIs('background-audio.createOrEdit') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="plus-square"></i> </div>
                        <div class="side-menu__title"> Add Audio </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('background-audio.index') }}" class="side-menu {{ request()->routeIs('background-audio.index') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="clipboard-list"></i> </div>
                        <div class="side-menu__title"> List </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;"
                class="side-menu {{ request()->routeIs('banner.index') || request()->routeIs('banner.createOrEdit') ? 'side-menu--active side-menu--open' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="image"></i> </div>
                <div class="side-menu__title">
                    Banner
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="{{ request()->routeIs('banner.index') || request()->routeIs('banner.createOrEdit') ? ' side-menu__sub-open' : '' }}">

                <li>
                    <a href="{{ route('banner.createOrEdit') }}" class="side-menu {{ request()->routeIs('banner.createOrEdit') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="plus-square"></i> </div>
                        <div class="side-menu__title"> Add Banner </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('banner.index') }}" class="side-menu {{ request()->routeIs('banner.index') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="clipboard-list"></i> </div>
                        <div class="side-menu__title"> List </div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="side-nav__devider my-6"></li>
        <li>
            <a href="{{route('setting.index')}}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="settings"></i> </div>
                <div class="side-menu__title"> Settings </div>
            </a>
        </li>
    </ul>

</nav>
