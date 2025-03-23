<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ route('index') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/logo1111.png') }}" alt="site logo" class="light-logo">
            <img src="{{ asset('assets/images/logo-light.png') }}" alt="site logo" class="dark-logo">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li >
                <a href="{{ route('index3') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="heroicons:bars-3-solid" class="menu-icon"></iconify-icon>
                    <span>Menue Management</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('user.menu.category.index') }}">
                            <iconify-icon icon="mdi:format-list-bulleted" class="menu-icon"></iconify-icon>
                            <span>Categories</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.menu.item.index') }}">
                            <iconify-icon icon="mdi:package-variant" class="menu-icon"></iconify-icon>
                            <span>Items</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('calendar') }}">
                            <iconify-icon icon="solar:calendar-outline" class="menu-icon"></iconify-icon>
                            <span>Coupones</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kanban') }}">
                            <iconify-icon icon="material-symbols:map-outline" class="menu-icon"></iconify-icon>
                            <span>Orders</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0)">
                            <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                            <span>Invoice</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ route('invoiceList') }}"><i
                                        class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> List</a>
                            </li>
                            <li>
                                <a href="{{ route('invoicePreview') }}"><i
                                        class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Preview</a>
                            </li>
                            <li>
                                <a href="{{ route('invoiceAdd') }}"><i
                                        class="ri-circle-fill circle-icon text-info-main w-auto"></i> Add new</a>
                            </li>
                            <li>
                                <a href="{{ route('invoiceEdit') }}"><i
                                        class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Edit</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('email') }}">
                    <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
                    <span>Payment Log</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="heroicons:banknotes-solid" class="menu-icon"></iconify-icon>
                    <span>Payment Gateway</span>
                </a>

                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('email') }}">
                            <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
                            <span>Offline</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('chatMessage') }}">
                            <iconify-icon icon="bi:chat-dots" class="menu-icon"></iconify-icon>
                            <span>Online</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-menu-group-title">User Management</li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span>Customers</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('usersList') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Customer List</a>
                    </li>
                    <li>
                        <a href="{{ route('usersGrid') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Customer Grid</a>
                    </li>
                    {{-- <li>
                        <a  href="{{ route('addUser') }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Add User</a>
                    </li>
                    <li>
                        <a  href="{{ route('viewProfile') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> View Profile</a>
                    </li> --}}
                </ul>
                <a href="javascript:void(0)">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span>Admins</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('usersList') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Admins List</a>
                    </li>
                    <li>
                        <a href="{{ route('usersGrid') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Add Admin</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <i class="ri-user-settings-line text-xl me-6 d-flex w-auto"></i>
                    <span>Role & Access</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('roleAaccess') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Role & Access</a>
                    </li>
                    <li>
                        <a href="{{ route('assignRole') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Assign Role</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-menu-group-title">Settings</li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
