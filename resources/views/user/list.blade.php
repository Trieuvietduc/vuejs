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
        @if (Session::has('error'))
            <div class="alert alert-danger thongbao">
                {{ Session::get('error') }}
            </div>
        @endif
        <form action="{{ route('user.index') }}" method="get">
            <input type="text" name="search_input" id="search_input" class="form-control"
                value="{{ $request->search_input }}">
            <button class="btn btn-wraning" type="submit">Search</button>
        </form>
        <table class="table table-hover">
            <thead>

                <th>Stt</th>
                <th>@sortablelink('name', 'Họ Và Tên')</th>
                <th>Email</th>
                <th>chúc vụ</th>
                <th colspan="2"><a href="{{ route('user.create') }}">Add</a></th>
            </thead>
            <tbody>
                @foreach ($user as $value)
                  
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->role_type }}</td>
                            <td>
                                <form action="{{ route('user.destroy', $value->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn"
                                        onclick="return confirm('bạn có muốn xóa không')">DEl</button>
                                </form>|
                                @if ($value->deleted_at == null)
                                    <a href="{{ route('user.edit', $value->id) }}">EDIT</a>
                                @else
                                    <a href="{{ route('users.restore', $value->id) }}">khôi phục</a>
                                @endif

                            </td>
                        </tr>
                   
                @endforeach
            </tbody>
        </table>
        <div class="group-paginate">
            {{ $user->appends($list)->links() }}
        </div>
        @if (!empty($i))
            <a href="{{ route('user_onlyTrashed') }}">Dữ liệu vừa xóa</a>
        @else
            <a href="{{ route('user.index') }}">Quay lại</a>
        @endif

    </div>

</body>

</html>
