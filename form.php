<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Grup.php');
include('classes/Role.php');
include('classes/Idol.php');
include('classes/Template.php');

$idol = new Idol($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$temp = new Idol($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$role = new Role($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$grup = new Grup($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$idol->open();
$temp->open();
$role->open();
$grup->open();

$opt_role = null;
$opt_grup = null;

$img_edit = "";
$nama_edit = "";
$grup_edit = "";
$role_edit = "";

$view_form = new Template('templates/skinform.html');
if (!isset($_GET['edit'])) {

    if (isset($_POST['submit'])) {
        if ($idol->addData($_POST, $_FILES) > 0) {
            echo "
                <script>
                    alert('Data berhasil ditambahkan!');
                    document.location.href = 'index.php';
                </script>
                ";
        }
    }


    $role->getRole();
    while ($row = $role->getResult()) {
        $opt_role .= "<option value=" . $row['id_role'] . ">" . $row['role_idol'] . "</option>";
    }

    $grup->getGrup();
    while ($row = $grup->getResult()) {
        $opt_grup .= "<option value=" . $row['id_grup'] . ">" . $row['nama_grup'] . "</option>";
    }
} else if (isset($_GET['edit'])) {
    $_ID = $_GET['edit'];
    $temp->getIdol();
    $temp->getIdolById($_ID);
    $temp_fnl = $temp->getResult();
    $temp_img = $temp_fnl['foto_idol'];

    if (isset($_POST['submit'])) {
        if ($idol->updateData($_ID, $_POST, $_FILES, $temp_img) > 0) {
            echo "
                <script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'index.php';
                </script>
                ";
        } else {
            echo "
                <script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'tambah.php';
                </script>
                ";
        }
    }

    $idol->getIdolById($_ID);

    $row = $idol->getResult();
    $nama_edit = $row['nama'];
    $img_edit = $row['foto_idol'];
    $role_edit = $row['id_role'];
    $grup_edit = $row['id_grup'];

    $role->getRole();
    while ($row = $role->getResult()) {
        $select = ($row['id_role'] == $role_edit) ? 'selected' : "";
        $opt_role .= "<option value=" . $row['id_role'] . " . $select . >" . $row['role_idol'] . "</option>";
    }

    $grup->getGrup();
    while ($row = $grup->getResult()) {
        $select = ($row['id_grup'] == $grup_edit) ? 'selected' : "";
        $opt_grup .= "<option value=" . $row['id_grup'] . " . $select . >" . $row['nama_grup'] . "</option>";
    }
}

$view_form->replace('NAMA_DATA', $nama_edit);
$view_form->replace('IMAGE_DATA', $img_edit);
$view_form->replace('ROLE_DATA', $role_edit);
$view_form->replace('ROLE_OPTION', $opt_role);
$view_form->replace('GRUP_DATA', $grup_edit);
$view_form->replace('GRUP_OPTION', $opt_grup);

$view_form->write();

$idol->close();
$role->close();
$grup->close();
