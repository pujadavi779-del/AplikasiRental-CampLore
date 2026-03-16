<!DOCTYPE html>
<html>

<head>
    <title>List Barang Camera</title>
</head>

<body style="background:#0f172a; color:white; font-family:sans-serif; padding:30px;">

    <h1>List Barang Camera</h1>

    <table border="1" cellpadding="10">

        <tr>
            <th>Nama</th>
            <th>Stok</th>
            <th>Harga</th>
        </tr>

        @foreach($items as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->stock }}</td>
            <td>{{ $item->price }}</td>
        </tr>
        @endforeach

    </table>

</body>

</html>