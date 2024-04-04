@extends('layouts/layout')
@section('content')
<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Users Table</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Account</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $user)
								
							
							<tr>
								<td>
									<p>{{ $user->id }}</p>
								</td>
								<td>{{ $user->name }}</td>
								<td><span class="">{{ $user->phone }}</span></td>
								<td>{{ $user->email }}</td>
								<td class="Action"><form  method ="Post" action="admindash/{{$user->id}}">
									@method('Delete')
									@csrf
									<button type="submit" class="status pending" >Delete</button>

								</form>
									<form method="Post" action="{{route('admin.block', ['id' => $user->id])}}">
										@csrf
										<button type="submit" class="status completed">Block</button>
									</form>
									
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
@endsection


