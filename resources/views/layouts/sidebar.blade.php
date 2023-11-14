<nav class="sidebar sidebar-offcanvas" id="sidebar">
	<ul class="nav">
	<!-- Super Admin -->
	@if(auth()->user()->getrole->name=='Super Admin')
		<li class="nav-item">
			<a class="nav-link" href="{{route('roles.index')}}">
			<span class="menu-title">Roles</span>
			<i class="mdi mdi-home menu-icon"></i>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{route('users.index')}}">
			<span class="menu-title">Users</span>
			<i class="mdi mdi-home menu-icon"></i>
			</a>
		</li>
	<!-- Scraper -->
	@elseif(auth()->user()->getrole->name=='Scraper')
		<li class="nav-item">
			<a class="nav-link" href="{{route('scraper_dashboard')}}">
			<span class="menu-title">Websites</span>
			<i class="mdi mdi-home menu-icon"></i>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{route('scraper_imported')}}">
			<span class="menu-title">Imported Data</span>
			<i class="mdi mdi-home menu-icon"></i>
			</a>
		</li>
	<!-- Support -->
	@elseif(auth()->user()->getrole->name=='Support')
		<li class="nav-item">
			<a class="nav-link" href="{{route('list.index')}}">
			<span class="menu-title">Lists</span>
			<i class="mdi mdi-home menu-icon"></i>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{route('import.index')}}">
			<span class="menu-title">Import</span>
			<i class="mdi mdi-home menu-icon"></i>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{route('website.index')}}">
			<span class="menu-title">Manage Website</span>
			<i class="mdi mdi-home menu-icon"></i>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{route('scrapped_data.index')}}">
			<span class="menu-title">Scrapped Data</span>
			<i class="mdi mdi-home menu-icon"></i>
			</a>
		</li>
	@endif
	</ul>
</nav>
