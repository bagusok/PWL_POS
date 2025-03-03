<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>

<body>
    <h1>Edit User</h1>

    <form action="/user/ubah_simpan/{{ $user->user_id }}" method="post">
        {{ csrf_field() }}
        <label for="">Username</label>
        <input type="text" name="username" id="username" placeholder="Masukkan Username" value="{{ $user->username }}">
        <br>
        <label for="">Nama</label>
        <input type="text" name="nama" id="nama" placeholder="Masukkan Nama" value="{{ $user->nama }}">
        <br>
        <label for="">Password</label>
        <input type="password" name="password" id="password" placeholder="Masukkan Password"
            value="{{ $user->password }}">
        <br>
        <label for="">Level Id</label>
        <input type="text" name="level_id" id="level_id" placeholder="Masukkan Level Id"
            value="{{ $user->level_id }}">
        <br>
        <button type="submit">Simpan</button>
    </form>

</body>

</html>
