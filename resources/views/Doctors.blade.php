<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Table</title>
    <link rel="stylesheet" href="{{asset('css/Doctors_style.css')}}">
</head>
<body>
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
                    <form action="">
                        @csrf
                        @method('Delete')
                         <button class="delete" type="submit">Delete</button>
                    </form>
                   
                    <button class="Edit">Edit</button> 
                </td>
                
                </tr>
                @endforeach
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <script src="{{asset('js/Doctors_lava.js')}}"></script>
</body>
</html>