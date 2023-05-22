<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Grup.php');
include('classes/Role.php');
include('classes/Idol.php');
include('classes/Template.php');

$idol = new Idol($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$idol->open();

$data = nulL;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $idol->getIdolById($id);
        $row = $idol->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['nama'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['foto_idol'] . '" class="img-thumbnail" alt="' . $row['foto_idol'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>' . $row['nama'] . '</td>
                                </tr>
                                <tr>
                                    <td>Divisi</td>
                                    <td>:</td>
                                    <td>' . $row['role_idol'] . '</td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td>' . $row['nama_grup'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="form.php?edit=' . $row['id'] . '"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
                <a href="detail.php?del=' . $row['id'] . '"><button type="button" class="btn btn-danger">Hapus Data</button></a>
            </div>';
    }
}
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    if ($id > 0) {
        if ($idol->deleteData($id) > 0) {
            echo
            "
            <script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>
            ";
        } else {
            echo
            "
            <script>
                alert('Data gagal dihapus!');
                document.location.href = 'index.php';
            </script>
            ";
        }
    }
}

$idol->close();

$detail = new Template('templates/skindetail.html');

$detail->replace('DATA_DETAIL_IDOL', $data);

$detail->write();
