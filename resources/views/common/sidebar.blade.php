<?php 
if(auth()->user())
{
$roleid = auth()->user()->role_id;
}else{

$roleid = Auth::guard('web_employees')->user()->role_id;
}
?>
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu"></span></li>
                 <li class="nav-item">
                    <a class="nav-link menu-link @if (request()->routeIs('home')) {{ 'active' }} @endif"
                        href="{{ route('home') }}">
                        <i class="mdi mdi-speedometer"></i>
                        <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                @if($roleid == '1' && $roleid != '2')
                   
                    <!-- Category -->
                    <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('admin.category.*')) active @endif"
                            href="{{ route('admin.category.index') }}">
                            <i class="fas fa-folder"></i>
                            <span data-key="t-category">Category</span>
                        </a>
                    </li>
                 
                    <!-- Sub Category -->
                    <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('admin.sub-category.*')) active @endif"
                            href="{{ route('admin.sub-category.index') }}">
                            <i class="fas fa-folder-open"></i>
                            <span data-key="t-sub-category">Sub Category</span>
                        </a>
                    </li>
                 
                    
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>