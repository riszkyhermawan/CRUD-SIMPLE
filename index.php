<?Php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "crud";


$connect    = mysqli_connect($host, $user, $pass, $db);

$nama_pemilik       = "";
$no_telp            = "";
$email              = "";
$nama_toko          = "";
$alamat_toko        = "";
$status_toko        = "";
$succes             = "";
$error              = "";

if(isset($_GET['op'])){
    $op     =$_GET['op'];
}else {
    $op     ="";
}

if($op=='delete'){
    $id         =$_GET['id'];
    $sql1       ="delete from reseller where id='$id'";
    $q1         =mysqli_query($connect,$sql1);
    if($q1){
        $succes ="Data berhasil dihapus";
    }else {
        $error  ="Gagal menghapus data";
    }
}



if($op=='edit'){
    $id             = $_GET['id'];
    $sql1           = "SELECT * from reseller where id = '$id' ";
    $q1             = mysqli_query($connect,$sql1);
    $r1             = mysqli_fetch_array($q1);
    $nama_pemilik   = $r1['namapemilik'];
    $no_telp        = $r1['nomor'];
    $email          = $r1['email'];
    $nama_toko      = $r1['namatoko'];
    $alamat_toko    = $r1['alamattoko'];
    $status_toko    = $r1['statustoko'];

    if($nama_pemilik==''){
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['create'])) {
    $nama_pemilik       = $_POST['nama-pemilik'];
    $no_telp            = $_POST['no-telp'];
    $email              = $_POST['email'];
    $nama_toko          = $_POST['nama-toko'];
    $alamat_toko        = $_POST['alamat-toko'];
    $status_toko        = $_POST['status-toko'];

    if ($nama_pemilik && $no_telp && $email && $nama_toko && $alamat_toko && $status_toko) {
        if($op=='edit'){
            $sql1   = "update reseller set namapemilik='$nama_pemilik', nomor='$no_telp', email='$email', namatoko='$nama_toko', alamattoko='$alamat_toko', statustoko='$status_toko' where id='$id' ";
            $q1     =mysqli_query($connect,$sql1);
            if($q1){
                $succes ="Data berhasil diupdate";
            }else {
                $error ="Gagal mengupdate data";
            }
        }else {
            $sql1   = "insert into reseller(namapemilik, nomor, email, namatoko, alamattoko, statustoko) values ('$nama_pemilik','$no_telp','$email','$nama_toko','$alamat_toko','$status_toko')";
            $q1    = mysqli_query($connect, $sql1);
    
            if ($q1) {
                $succes = "Berhasil memasukan data";
            } else {
                $error = "Gagal memasukan data";
            }
        }

    }else {
        $error      = "Silahkan masukan semua data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Reseller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Create /Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:3;url=index.php");
                }
                ?>
                <?php
                if ($succes) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $succes ?>
                    </div>
                    <?php
                    header("refresh:3;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nama-pemilik" class="col-sm-2 col-form-label">Nama Pemilik</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama-pemilik" id="nama-pemilik" value="<?php echo $nama_pemilik ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="No. Telp/WA" class="col-sm-2 col-form-label">No. Telp/WA</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="no-telp" id="no-telp" value="<?php echo $no_telp ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="email" id="email" value="<?php echo $email ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama-toko" class="col-sm-2 col-form-label">Nama Toko</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama-toko" id="nama-toko" value="<?php echo $nama_toko ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat-toko" class="col-sm-2 col-form-label">Alamat Toko</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="alamat-toko" id="alamat-toko" value="<?php echo $alamat_toko ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="status-toko" class="col-sm-2 col-form-label">Status Toko</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status-toko" id="status-toko">
                                <option value="">- Pilih Status-</option>
                                <option value="aktif" <?php if ($status_toko == "aktif") echo "selected" ?>>Aktif</option>
                                <option value="tidak-aktif" <?php if ($status_toko == "tidak-aktif") echo "selected" ?>>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 create">
                        <button type="submit" name="create" value="create" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Reseller
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Pemilik</th>
                            <th scope="col">No. Telp/WA</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nama Toko</th>
                            <th scope="col">Alamat Toko</th>
                            <th scope="col">Status Toko</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2   = "SELECT * from reseller order by id desc";
                        $q2     = mysqli_query($connect, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id             = $r2['id'];
                            $nama_pemilik   = $r2['namapemilik'];
                            $no_telp        = $r2['nomor'];
                            $email          = $r2['email'];
                            $nama_toko      = $r2['namatoko'];
                            $alamat_toko    = $r2['alamattoko'];
                            $status_toko    = $r2['statustoko'];
                        }
                        ?>
                        <tr>
                            <td scope="row"><?php echo $urut++ ?></td>
                            <td scope="row"><?php echo $nama_pemilik ?></td>
                            <td scope="row"><?php echo $no_telp ?></td>
                            <td scope="row"><?php echo $email ?></td>
                            <td scope="row"><?php echo $nama_toko ?></td>
                            <td scope="row"><?php echo $alamat_toko ?></td>
                            <td scope="row"><?php echo $status_toko ?></td>
                            <td scope="row">
                                <div class="d-grid gap-2 justify-content-md-end">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button class="btn btn-warning" type="button">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Apakah Anda yakin untuk menghapus data?')"><button class="btn btn-danger" type="button">Delete</button></a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

</html>