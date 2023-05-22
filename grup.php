<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Grup.php');
include('classes/Template.php');

$grup = new Grup($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$grup->open();
$grup->getGrup();

if (isset($_POST['btn-cari'])) {
    $grup->searchGrup($_POST['cari']);
} else if (isset($_POST['btn-asc'])) {
    $grup->filterGrupAsc();
} else if (isset($_POST['btn-desc'])) {
    $grup->filterGrupDesc();
}

if (!isset($_GET['id_grup'])) {
    if (isset($_POST['submit'])) {
        if ($grup->addGrup($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'grup.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'grup.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Grup';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Grup</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'Grup';

while ($div = $grup->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['nama_grup'] . '</td>
    <td style="font-size: 22px;">
        <a href="grup.php?id_grup=' . $div['id_grup'] . '" title="Edit Data">
        <i class="bi bi-pencil-square text-warning"></i>
        </a>&nbsp;
        <a href="grup.php?hapus=' . $div['id_grup'] . '" title="Delete Data">
        <i class="bi bi-trash-fill text-danger"></i>
        </a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id_grup'])) {
    $id = $_GET['id_grup'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($grup->updateGrup($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'grup.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'grup.php';
            </script>";
            }
        }

        $grup->getGrupById($id);
        $row = $grup->getResult();

        $dataUpdate = $row['nama_grup'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($grup->deleteGrup($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'grup.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'grup.php';
            </script>";
        }
    }
}

$grup->close();

$view->replace('LINK', 'grup.php');

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);

$view->write();
