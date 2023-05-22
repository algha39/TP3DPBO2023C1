<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Role.php');
include('classes/Template.php');

$role = new Role($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$role->open();
$role->getRole();

if (isset($_POST['btn-cari'])) {
    $role->searchRole($_POST['cari']);
} else if (isset($_POST['btn-asc'])) {
    $role->filterRoleAsc();
} else if (isset($_POST['btn-desc'])) {
    $role->filterRoleDesc();
}

if (!isset($_GET['id_role'])) {
    if (isset($_POST['submit'])) {
        if ($role->addRole($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'role.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'role.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Role';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Role</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'Role';

while ($div = $role->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['role_idol'] . '</td>
    <td style="font-size: 22px;">
        <a href="role.php?id_role=' . $div['id_role'] . '" title="Edit Data">
        <i class="bi bi-pencil-square text-warning"></i>
        </a>&nbsp;
        <a href="role.php?hapus=' . $div['id_role'] . '" title="Delete Data">
        <i class="bi bi-trash-fill text-danger"></i>
        </a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id_role'])) {
    $id = $_GET['id_role'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($role->updateRole($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'role.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'role.php';
            </script>";
            }
        }

        $role->getRoleById($id);
        $row = $role->getResult();

        $dataUpdate = $row['role_idol'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($role->deleteRole($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'role.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'role.php';
            </script>";
        }
    }
}

$role->close();

$view->replace('LINK', 'role.php');

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);

$view->write();
