<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Table</title>
    <link rel="stylesheet" href="{{secure_asset('css/Doctors_style.css')}}">
	<!-- Boxicons -->
	<link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="{{secure_asset('css/style.css')}}">
</head>
<body>

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
				<a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        	<i class='bx bxs-log-out-circle'></i>
        <span class="text">Logout</span>
    		</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
       		 @csrf
    		</form>
			</li>
		</ul>
	</section>
    <div class="container">
        <h1>Doctors</h1>
        <table id="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Rate</th>
                    <th>Phone</th>
                    <th>Governorate</th>
                    <th>Latitude Lines</th>
                    <th>longitude Lines</th>
                    <th>Actions</th>
                </tr>
                @foreach ($doctors as $doctor)
                <tr>
                <th>{{ $doctor->id }}</th>
                <th>{{ $doctor->name }}</th>
                <th>{{ $doctor->rate}}/5</th>
                <th>{{ $doctor->phone }}</th>
                <th>{{ $doctor->gover }}</th>
                <th>{{ $doctor->lat }}</th>
                <th>{{ $doctor->lang }}</th>
                <td class="actions">
                    <form action="/delete_doctor/{{ $doctor->id }}" method="POST">
                        @csrf
                        @method('Delete')
                         <button class="delete" type="submit">Delete</button>
                    </form>
                    <form action="/edit_doctor/{{ $doctor->id }}">
                        @csrf
                        <button class="Edit" type="submit">Edit</button>
                    </form>
                   
                     
                </td>
                
                </tr>
                @endforeach
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    
    <script src="{{secure_asset('js/Doctors_lava.js')}}"></script>
</body>
</html>