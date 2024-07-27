<div class="left-side-bar">
	<div class="brand-logo">
		<a href="{{route('adminDashboard')}}">
			<img src="{{ asset('assets/vendors/images/deskapp-logo.svg')}}" alt="" class="dark-logo" />
			<img src="{{ asset('assets/vendors/images/deskapp-logo-white.svg')}}" alt="" class="light-logo" />
		</a>
		<div class="close-sidebar" data-toggle="left-sidebar-close">
			<i class="ion-close-round"></i>
		</div>
	</div>
	<div class="menu-block customscroll">
		<div class="sidebar-menu">
			<ul id="accordion-menu">
				<li class="dropdown">
					<a href="{{route('adminDashboard')}} " class="dropdown-toggle no-arrow {{ Request::routeIs('adminDashboard') ? 'active' : '' }}">
						<span class="micon bi bi-house"></span><span class="mtext">Home</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="{{route('users.index')}}" class="dropdown-toggle no-arrow {{ Request::routeIs('users.index') ? 'active' : '' }}">
						<span class="micon bi bi-people"></span><span class="mtext">User</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="{{route('employee-users.index')}}" class="dropdown-toggle no-arrow {{ Request::routeIs('employeeUsers.index') ? 'active' : '' }}">
						<span class="micon bi bi-people"></span><span class="mtext">EmployeeUser</span>
					</a>
				</li>
                <li class="dropdown">
					<a href="{{route('jobrequest.index')}}" class="dropdown-toggle no-arrow">
						<span class="micon bi bi-people"></span><span class="mtext">Job Request</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="{{route('job-categories.index')}}" class="dropdown-toggle no-arrow {{ Request::routeIs(['job-categories.index', 'jobs.index']) ? 'active' : '' }}">
						<span class="micon bi bi-people"></span><span class="mtext">Job Category</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="{{route('jobs.index')}}" class="dropdown-toggle no-arrow {{ Request::routeIs(['job-categories.index', 'jobs.index']) ? 'active' : '' }}">
						<span class="micon bi bi-people"></span><span class="mtext">Job </span>
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
			</li>
            <li class="dropdown">
                <a href="{{route('banners.index')}}" class="dropdown-toggle no-arrow {{ Request::routeIs('banners.index') ? 'active' : '' }}">
                    <span class="micon bi bi-people"></span><span class="mtext">Banner</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="{{route('services.index')}}" class="dropdown-toggle no-arrow {{ Request::routeIs('services.index') ? 'active' : '' }}">
                    <span class="micon bi bi-people"></span><span class="mtext">Services</span>
                </a>
            </li>
			{{-- <li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle">
					<span class="micon bi bi-textarea-resize"></span><span class="mtext">Category</span>
				</a>
				<ul class="submenu">
					<li><a href="{{route('section.index')}}">Section</a></li>
					<li><a href="{{route('section.index')}}">Category</a></li>
					<li><a href="{{route('section.index')}}">Sub Category</a></li>
				</ul>
			</li> --}}
			{{-- <li class="dropdown">
				<a href="{{route('job-categories.index')}}" class="dropdown-toggle no-arrow">
					<span class="micon bi bi-house"></span><span class="mtext">HomePage</span>
				</a>
			</li> --}}
			</ul>
		</div>
	</div>
</div>
<div class="mobile-menu-overlay"></div>
