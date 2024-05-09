<?php

session_start();
if(!isset($_SESSION['login'])) {
    header('Location:login.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Peserta</title>
    <!-- link bootstrap -->
    <link rel="stylesheet" href="assets/bootstrap.min.css" />
    <!-- link css -->
    <link rel="stylesheet" href="assets/style.css" />
    <style>
    @media print {

        .cetak,
        .navbar,
        .aksi,
            {
            display: none;
        }
    }
    </style>
</head>

<body>
    <nav class=" navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand p-0" href="#">
                <a class="navbar-brand" href="index.php">DIGITAL TALENT</a>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-center">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php?fungsi=read">Calon Peserta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php?fungsi=create">Daftar Baru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white border rounded" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
    include('koneksi.php');
    // Program Utama 
    if (isset($_GET['fungsi'])){
        switch($_GET['fungsi']){
            case "create":
                create($db);
                break;
            case "create_success":
                create_success();
                break;
            case "read":
                read($db);
                break;
            case "update":
                update($db);
                break;
            case "update_success":
                update_success();
                break;
            case "delete":
                delete($db);
                break;
            case "delete_success":
                delete_success();
                break;
            default:
                read($db);
        }
    } else {
            mainpage();
    }

    // Fungsi Halaman Awal (Home)
    function mainpage(){
    echo'
    <div class="container" style="margin-top:20px">
        <h3>Pendaftaran Peserta Digital Telent</h3>
        <hr>
        <p> Silahkan pilih Menu <b>Daftar Baru</b> untuk menambahkan peserta baru </p>
    </div>';
    }

    // Fungsi Tambah Data (Create)
    function create($db){
        if (isset($_POST['btn_simpan'])){
            $nama_peserta = $_POST['nama_peserta'];
            $alamat = $_POST['alamat'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $agama = $_POST['agama'];
            $sekolah_asal = $_POST['sekolah_asal'];
            if(!empty($nama_peserta) && !empty($alamat) && !empty($jenis_kelamin) && !empty($agama) && !empty($sekolah_asal)){
                $sql = "INSERT INTO tb_siswa (id_peserta,nama_peserta, alamat, jenis_kelamin, agama, sekolah_asal) VALUES('','".$nama_peserta."','".$alamat."','".$jenis_kelamin."','".$agama. "','".$sekolah_asal."')";
                $simpan = mysqli_query($db, $sql);
                if($simpan && isset($_GET['fungsi'])){
                    if($_GET['fungsi'] == 'create'){
                        header('location: index.php?fungsi=create_success');
                    }
                }
            } else {
                $pesan = "Tidak dapat menyimpan, data belum lengkap!";
            }
        }
    ?>
    <div class="container" style="margin-top:20px">
        <h2>Tambah Data Peserta</h2>
        <form action="index.php?fungsi=create" method="post">
            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_peserta" class="form-control" size="4" required>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <textarea name="alamat" class="form-control" required></textarea>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="jenis_kelamin" value="L" required>
                        <label class="form-check-label">Laki-laki</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="jenis_kelamin" value="P" required>
                        <label class="form-check-label">Perempuan</label>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label">Agama</label>
                <div class="col-sm-10">
                    <select name="agama" class="form-control" required>
                        <option value="">Pilih salah satu</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen Protestan">Kristen Protestan</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Budha">Budha</option>
                        <option value="Kepercayaan lainnya">Kepercayaan lainnya</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label">Sekolah Asal</label>
                <div class="col-sm-10">
                    <input type="text" name="sekolah_asal" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">&nbsp;</label>
                <div class="col-sm-10">
                    <input type="submit" name="btn_simpan" class="btn btn-primary" value="Simpan">
                    <input type="reset" name="btn_reset" class="btn btn-info" value="Reset">
                    <a href="index.php" class="btn btn-success" role="button">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    <?php
    }   

    //Fungsi Tampilan halaman berhasil tambah data
    function create_success(){
        echo'
        <div class="container" style="margin-top:20px">
            <h3>Data Calon Peserta Digital Telent</h3>
            <hr>
            <p> Pendaftaran Berhasil </p>
        </div>';
    }
    
    //Fungsi Baca Data (Read)
    function read($db){
        echo'
        <div class="container" style="margin-top:20px">
            <h2>Pendaftar</h2>
            <hr>
            <a class="btn btn-success px-4 py-2 my-2 cetak" onclick="cetak()">Cetak PDF</a>
            <table class="table table-striped table-hover table-sm table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama</th>
                        <th>Sekolah Asal</th>
                        <th class="aksi">Tindakan</th>
                    </tr>
                </thead>
            <tbody>';
                $sql = "SELECT * FROM tb_siswa";
                $query = mysqli_query($db, $sql);
                if(mysqli_num_rows($query) > 0){
                    $no=1;
                    while($data = mysqli_fetch_assoc($query)){
                        echo '
                        <tr>
                            <td>'.$no.'</td>
                            <td>'.$data['nama_peserta'].'</td>
                            <td>'.$data['alamat'].'</td>
                            <td>'.$data['jenis_kelamin'].'</td>
                            <td>'.$data['agama'].'</td>
                            <td>'.$data['sekolah_asal'].'</td>
                            <td class="aksi">
                                <a href="index.php?fungsi=update&id_peserta='.$data['id_peserta'].'" class="btn btn-warning">Edit</a>
                                <a href="index.php?fungsi=delete&id_peserta='.$data['id_peserta'].'" class="btn btn-danger" onclick="return confirm(\'Yakin ingin menghapus data ini?\')">Delete</a>
                            </td>
                        </tr>';
                        $no++;
                    }
                }else{
                    echo 
                    '<tr>
                        <td colspan="6">Tidak ada data.</td>
                    </tr>';
                }
                    echo
            '<tbody>
        </table>
    </div>';
    }

    // Fungsi Ubah Data (Update)
    function update($db){
        if (isset($_POST['btn_simpan'])){
            $id_peserta = $_POST['id_peserta'];
            $nama_peserta = $_POST['nama_peserta'];
            $alamat = $_POST['alamat'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $agama = $_POST['agama'];
            $sekolah_asal = $_POST['sekolah_asal'];
            if(!empty($nama_peserta) && !empty($alamat) && !empty($jenis_kelamin) && !empty($agama) && !empty($sekolah_asal)){
                $sql = "UPDATE tb_siswa SET nama_peserta='$nama_peserta', alamat='$alamat', jenis_kelamin='$jenis_kelamin', agama='$agama', sekolah_asal='$sekolah_asal' WHERE id_peserta='$id_peserta'";
                $update = mysqli_query($db, $sql);
                if($update && isset($_GET['fungsi'])){
                    if($_GET['fungsi'] == 'update'){
                        header('location: index.php?fungsi=update_success');
                    }
                }
            } else {
                $pesan = "Tidak dapat menyimpan, data belum lengkap!";
            }
        } else {
            $id_peserta = $_GET['id_peserta'];
            $sql_peserta = "SELECT * FROM tb_siswa WHERE id_peserta=" . $id_peserta;
            $query_peserta = mysqli_query($db, $sql_peserta);
            $data_peserta = mysqli_fetch_assoc($query_peserta);
        }
        ?>
    <div class="container" style="margin-top:20px">
        <h2>Update Data Peserta</h2>
        <form action="index.php?fungsi=update" method="post">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_peserta" class="form-control" size="4"
                        value=" <?php echo $data_peserta['nama_peserta']; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <textarea name="alamat" class="form-control"
                        required><?php echo $data_peserta['alamat']; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="jenis_kelamin" value="Laki-laki"
                            <?php if($data_peserta['jenis_kelamin'] == 'L'){ echo 'checked'; } ?> required>
                        <label class="form-check-label">Laki-laki</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="jenis_kelamin" value="Perempuan"
                            <?php if($data_peserta['jenis_kelamin'] == 'P'){ echo 'checked'; } ?> required>
                        <label class="form-check-label">Perempuan</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Agama</label>
                <div class="col-sm-10">
                    <select name="agama" class="form-control" required>
                        <option value="">Pilih salah satu</option>
                        <option value="Islam" <?php if($data_peserta['agama'] == 'Islam'){ echo 'selected'; } ?>>Islam
                        </option>
                        <option value="Kristen Protestan"
                            <?php if($data_peserta['agama'] == 'Kristen Protestan'){ echo 'selected'; } ?>>Kristen
                            Protestan</option>
                        <option value="Katolik" <?php if($data_peserta['agama'] == 'Katolik'){ echo 'selected'; } ?>>
                            Katolik</option>
                        <option value="Hindu" <?php if($data_peserta['agama'] == 'Hindu'){ echo 'selected'; } ?>>Hindu
                        </option>
                        <option value="Budha" <?php if($data_peserta['agama'] == 'Budha'){ echo 'selected'; } ?>>Budha
                        </option>
                        <option value="Kepercayaan lainnya"
                            <?php if($data_peserta['agama'] == 'Kepercayaan lainnya'){ echo 'selected'; } ?>>Kepercayaan
                            lainnya</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Sekolah Asal</label>
                <div class="col-sm-10">
                    <input type="text" name="sekolah_asal" class="form-control"
                        value="<?php echo $data_peserta['sekolah_asal']; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">&nbsp;</label>
                <div class="col-sm-10">
                    <input type="hidden" name="id_peserta" value="<?php echo $id_peserta; ?>">
                    <input type="submit" name="btn_simpan" class="btn btn-primary" value="Simpan">
                    <a href="index.php" class="btn btn-success" role="button">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    <?php
    }
    
    //Fungsi update data peserta berhasil tambah data
    function update_success(){
        echo'
        <div class="container" style="margin-top:20px">
            <h3>Data Calon Peserta Digital Telent</h3>
            <hr>
            <p> Update Data Peserta Berhasil </p>
        </div>';
    }

    // Fungsi Delete
    function delete($db){
        if(isset($_GET['id_peserta']) && isset($_GET['fungsi'])){
        $id_peserta = $_GET['id_peserta'];
        $sql_hapus = "DELETE FROM tb_siswa WHERE id_peserta=" . $id_peserta;
        $hapus = mysqli_query($db, $sql_hapus);
        if($hapus){
            if($_GET['fungsi'] == 'delete'){
                header('location: index.php?fungsi=delete_success');
            }
        }
    }
    }

    // Fungsi delete data peserta berhasil tambah data
    function delete_success(){
        echo'
        <div class="container" style="margin-top:20px">
            <h3>Data Calon Peserta Digital Telent</h3>
            <hr>
            <p> Delete Data Peserta Berhasil </p>
        </div>';
    }
    // function report($db) {
    //     $content = '
    //     <img src="logo.png " alt="logo" style="width:50px; float:left;">
    //         <h2 style="margin:10px,5px">Daftar Mahasiswa Pelatihan VSGA</h2>
    //         <hr>
    //         <table border="1" cellpadding="2" style="width:100%">
    //             <thead>
    //                 <tr>
    //                     <th>No</th>
    //                     <th>Nama</th>
    //                     <th>Alamat</th>
    //                     <th>Jenis Kelamin</th>
    //                     <th>Agama</th>
    //                     <th>Sekolah Asal</th>
    //                 </tr>
    //             </thead>
    //             <tbody>';
    //             $sql =mysqli_query($db, "SELECT * FROM tb_siswa");
    //                 $no=1;
    //                 while($data =mysqli_fetch_assoc($sql)){
    //             $content .='<tr>
    //                     <td>'.$no.'</td>
    // <td>'.$data["nama_peserta"].'</td>
    // <td>'.$data["alamat"].'</td>
    // <td>'.$data["jenis_kelamin"].'</td>
    // <td>'.$data["agama"].'</td>
    // <td>'.$data["sekolah_asal"].'</td>
    // </tr>';
    // $no++;
    // }
    
    // $content.= '</tbody>
    // </table>
    // </div>';
    
    //     require_once "./mpdf_v8.0.3-master/vendor/autoload.php";
    //     $mpdf = new \Mpdf\Mpdf();
    //     $mpdf->AddPage("P","","","","","15","15","15","15","","","","","","","","","","","","A4");
    //     $mpdf->WriteHTML($content);
    //     $mpdf->Output();
    //     }
    // ?>
    <!-- Script javascript -->
    <script src="assets/bootstrap.bundle.min.js"></script>
    <script>
    function cetak() {
        window.print();
    }
    </script>
</body>

</html>