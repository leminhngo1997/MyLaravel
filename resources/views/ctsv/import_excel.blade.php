@extends('ctsv.trangchu')
@section('main_content')

<div class="container-fluid">
    <h3>import excel</h3>

    @if(count($errors) > 0)
        <div class="alert alert-danger">
            Upload validation errors<br><br>
            <ul>
                @foreach ($errors -> all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <form method="post" enctype="multipart/form-data" action="{{ url('/import_excel/import') }}">
        {{ csrf_field() }}

        <input type="file" name="select_file"/>
        <input type="submit" name="upload" value="Upload"/>
    </form>

    <br>
    <table>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>email</th>
        </tr>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->email }}</td>
            </tr>
        @endforeach
    </table>
</div>

@endsection