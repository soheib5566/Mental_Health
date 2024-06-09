<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <link rel="stylesheet" href="{{secure_asset('css/Edit_Style.css')}}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            Add Doctor
        </h4>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <div class="card overflow-hidden">
            <form action="/store_doctor" method="POST">
                @csrf
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">Add Doctor</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control mb-1" name="name" value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Governorate</label>
                                    <input type="text" class="form-control" name="gover" value="{{ old('gover') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Latitude Lines</label>
                                    <input type="text" class="form-control" name="lat" value="{{ old('lat') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">longitude Lines</label>
                                    <input type="text" class="form-control" name="lang" value="{{ old('lang') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Rate</label>
                                    <input type="text" class="form-control" name="rate" value="{{ old('rate') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control mb-1" name="phone" value="{{ old('phone') }}">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-social-links">
                            <div class="card-body pb-2"></div>
                        </div>
                        <div class="tab-pane fade" id="account-connections">
                            <div class="card-body">
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="text-right mt-3">
            <button type="submit" class="btn btn-primary">Add</button>&nbsp;
            <button type="button" class="btn btn-default" onclick="window.location.href='/admindash'">Cancel</button>
        </div>
        </form>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>