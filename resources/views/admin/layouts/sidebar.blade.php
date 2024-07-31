<div class="left-side-bar">
	<div class="brand-logo">
		<a href="{{route('adminDashboard')}}">
			<img src="{{ asset('public/assets/vendors/images/deskapp-logo.svg')}}" alt="" class="dark-logo" />
			<img src="{{ asset('public/assets/vendors/images/deskapp-logo-white.svg')}}" alt="" class="light-logo" />
		</a>
		<div class="close-sidebar" data-toggle="left-sidebar-close">
			<i class="ion-close-round"></i>
		</div>
	</div>
	<div class="menu-block customscroll">
		<div class="sidebar-menu">
			<ul id="accordion-menu">
				<li class="dropdown">
					<a href="{{route('adminDashboard')}}"
						class="dropdown-toggle no-arrow {{ request()->is('admin/dashboard*') ? 'active' : ''}}">
						<span class="micon bi bi-house"></span><span class="mtext">Home</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="{{route('users.index')}}"
						class="dropdown-toggle no-arrow {{ request()->is('admin/users*') ? 'active' : ''}}">
						<span class="micon bi bi-people"></span><span class="mtext">User</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="{{route('employee-users.index')}}"
						class="dropdown-toggle no-arrow {{ request()->is('admin/employee-users*') ? 'active' : ''}}">
						<span class="micon bi bi-people"></span><span class="mtext">Employee User</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="{{route('jobrequest.index')}}" class="dropdown-toggle no-arrow {{ request()->is('admin/jobrequest*') ? 'active' : ''}}">
						<span class="micon bi bi-people"></span><span class="mtext">Job Request</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="{{route('job-categories.index')}}"
						class="dropdown-toggle no-arrow {{ request()->is('admin/job-categories*') ? 'active' : ''}}">
						<span class="micon bi bi-people"></span><span class="mtext">Job Category</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="{{route('jobs.index')}}"
						class="dropdown-toggle no-arrow {{ request()->is('admin/jobs*') ? 'active' : ''}}">
						<span class="micon bi bi-people"></span><span class="mtext">Job </span>
					</a>
				</li>
				<li class="dropdown">
					<a href="{{route('banners.index')}}"
						class="dropdown-toggle no-arrow {{ request()->is('admin/banners*') ? 'active' : ''}}">
						<span class="micon bi bi-people"></span><span class="mtext">Banner </span>
					</a>
				</li>
				<li class="dropdown">
					<a href="{{route('services.index')}}"
						class="dropdown-toggle no-arrow  {{ request()->is('admin/services*') ? 'active' : ''}}">
						<span class="micon bi bi-people"></span><span class="mtext">Services</span>
					</a>
				</li>
				<!-- <li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle {{ Request::routeIs(['job-categories.index', 'jobs.index']) ? 'active show' : '' }}">
						<span class="micon bi bi-textarea-resize"></span><span class="mtext">Job</span>
					</a>
					<ul class="submenu {{ Request::routeIs(['job-categories.index', 'jobs.index']) ? 'active' : '' }}">
						<li><a href="{{route('job-categories.index')}}">Job Category</a></li>
						<li><a href="{{route('jobs.index')}}">Job</a>
							</li>
				</li> -->





			</ul>
		</div>
	</div>
</div>
<div class="mobile-menu-overlay"></div>
