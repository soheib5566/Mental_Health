<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="{{asset('css/style.css')}}">

	<title>Dashboard</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Ozey</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="/admindash">
					<i class='bx bxs-dashboard'></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="/admindash/users">
					<i class='bx bxs-user'></i>
					<span class="text">Users</span>
				</a>
			</li>
			<li>
				<!-- هنا يتم استدعاء الدالة redirectToUsersPage() عند النقر -->
			<a href="/doctors">
					<i class='bx bxs-group'></i>
					<span class="text">Doctors</span>
				</a>
			</li>

			<li>
				<!-- هنا يتم استدعاء الدالة redirectToUsersPage() عند النقر -->
				<a href="/add_doctor">
					<i class='bx bxs-group'></i>
					<span class="text">Add Doctor</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#" class="logout">
					<i class='bx bxs-log-out-circle'></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>

    <!-- SIDEBAR -->




	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu'></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell'></i>
				<span class="num">8</span>
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li>
							<a class="active" href="/admindash">Home</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download'></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-group'></i>
					<span class="text">
						<h3>{{ $doctors_count }}</h3>
						<p>Doctors</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group'></i>
					<span class="text">
						<h3>{{ $userscount }}</h3>
						<p>Users</p>
					</span>
				</li>
			</ul>
			@yield('content')
		</main>
	</section>
	<script src="{{asset('js/script.js') }}"></script>
</body>

</html>