<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('super_admin.index') ? 'active' : '' }}"
                href="{{ route('super_admin.index') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('super_admin.faqs.index') ? 'active' : '' }}"
                href="{{ route('super_admin.faqs.index') }}">
                <i class="bi bi-menu-button-wide"></i>
                <span>Question/MCQS</span>
            </a>
        </li>

    </ul>
</aside><!-- End Sidebar -->