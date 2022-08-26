<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/js/app.js')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>

    <div class="container"><br><br>
        <form action="{{route('company.index')}}" method="get">
            <input type="text" name="search_input" id="search_input" class="form-control" value="{{$request->search_input}}">
            <button class="btn btn-wraning" type="submit">Search</button>
        </form>

        <table class="table table-hover">
            <thead>
                <th>Stt</th>
                <th class="code">@sortablelink('code', 'code')</th>
                <th>Họ và Tên</th>
                <th>Số điện thoại</th>
                <th>địa chỉ</th>
                <th colspan="2"><a href="{{ route('company.create') }}">Add</a></th>
            </thead>
            <tbody>
                @foreach ($company as $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->code }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->telephone }}</td>
                        <td>{{ $value->address }}</td>
                        <td>
                            <form action="{{ route('company.destroy', $value->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn" onclick="return confirm('bạn có muốn xóa không')">DEl</button>
                            </form>|
                            @if ($value->deleted_at == null)
                                <a href="{{ route('company.edit', $value->id) }}">EDIT</a>
                            @else
                                <a href="{{ route('companys.restore', $value->id) }}">khôi phục</a>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="group-paginate">
            {{ $company->appends($list)->links() }}
        </div>
        @if (empty($i))
            <a href="{{ route('company_onlyTrashed') }}">Dữ liệu vừa xóa</a>
        @else
            <a href="{{ route('company.index') }}">Quay lại</a>
        @endif

    </div>

</body>

</html>
