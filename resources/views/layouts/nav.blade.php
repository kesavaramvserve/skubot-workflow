<style>
	.navbar .navbar-brand-wrapper .navbar-brand img{
		height:70px !important;
	}
</style>
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
	<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
		<a class="navbar-brand brand-logo" href=""><img src="{{asset('assets/images/logo.jpg')}}" alt="logo" /></a>
		<a class="navbar-brand brand-logo-mini" href=""><img src="{{asset('assets/images/logo-mini.svg')}}" alt="logo" /></a>
	</div>
	<div class="navbar-menu-wrapper d-flex align-items-stretch">
		<!-- <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
		<span class="mdi mdi-menu"></span>
		</button>
		<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
		<span class="mdi mdi-menu"></span>
		</button> -->
		@auth
		<ul class="navbar-nav ms-auto">
			<li class="">
				<span class="badge badge-success">{{ auth()->user()->getRole->name }}</span>
			</li>
			<li class="nav-item dropdown">
				<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
					{{ Auth::user()->name }}
				</a>

				<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="{{ route('logout') }}"
						onclick="event.preventDefault();
										document.getElementById('logout-form').submit();">
						{{ __('Logout') }}
					</a>

					<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
						@csrf
					</form>
				</div>
			</li>
		</ul>
		@endauth 
	</div>
</nav>