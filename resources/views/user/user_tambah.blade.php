<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
</head>

<body>
    <h1>Tambah User</h1>

    <form action="/user/tambah_simpan" method="post">
        {{ csrf_field() }}
        <label for="">Username</label>
        <input type="text" name="username" id="username" placeholder="Masukkan Username">
        <br>
        <label for="">Nama</label>
        <input type="text" name="nama" id="nama" placeholder="Masukkan Nama">
        <br>
        <label for="">Password</label>
        <input type="password" name="password" id="password" placeholder="Masukkan Password">
        <br>
        <label for="">Level Id</label>
        <input type="text" name="level_id" id="level_id" placeholder="Masukkan Level Id">
        <br>
        <button type="submit">Simpan</button>
    </form>

</body>

</html>
