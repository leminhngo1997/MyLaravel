<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>jQuery load() Demo</title>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
{{-- <script>
$(document).ready(function(){
    $("button").click(function(){
        $("#box").load("test.test1");
    });
});
</script> --}}
</head>
<body>
    <form action="{{url('get-user-test')}}" method="POST">
        {{csrf_field()}}
    <div>
        <select name="bangdiem_id">
            <option value="3">3</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="9">9</option>
            <option value="1">1</option>
        </select>
        <button type="submit">submit</button>
    </div>
    </form>
</body>
</html>