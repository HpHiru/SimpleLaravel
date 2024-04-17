<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Datas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container" style="padding: 20px;">
        <div class="row">
            <div class="col-md-10">
                <p class=" mt-5 mb-5"><h3>Hello, {{@\Auth::user()->name?:""}}</h3></p>
            </div>
            <div class="col-md-2">
                <a href="{{route('logout')}}" class="btn btn-primary mt-5 mb-5">Logout</a>
            </div>
        </div>
        <div class="add-data" style="padding: 20px;border: 1px solid black;text-align: center">
            <h1 class="mt-5 mb-5">Add Dummy Data in Sale And Sale Item Table</h1>
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <form action="{{ route('add-data') }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-primary">Add Data</button>
            </form>
        </div>
        <br><br>
        <div class="product-import"  style="padding: 20px;border: 1px solid black;text-align: center">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('import-products') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" class="form-control" name="file">
                @if ($errors->has('file'))
                    <label class="text-danger">{{ $errors->first('file') }}</label>
                @endif
                <br>
                <button class="btn btn-success mt-5" type="submit">Import Products</button>
            </form>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
