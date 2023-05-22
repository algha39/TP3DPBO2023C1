<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Grup.php');
include('classes/Role.php');
include('classes/Idol.php');
include('classes/Template.php');

$listIdol = new Idol($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$listIdol->open();
$listIdol->getIdolJoin();

if (isset($_POST['btn-cari'])) {
    $listIdol->searchIdol($_POST['cari']);
} else if (isset($_POST['btn-asc'])) {
    $listIdol->filterIdolAsc();
} else if (isset($_POST['btn-desc'])) {
    $listIdol->filterIdolDesc();
} else {
    $listIdol->getIdolJoin();
}

$data = null;

while ($row = $listIdol->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 idol-thumbnail">
        <a href="detail.php?id=' . $row['id'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['foto_idol'] . '" class="card-img-top" alt="' . $row['foto_idol'] . '">
            </div>
            <div class="card-body">
                <p class="card-text idol-nama my-0">' . $row['nama'] . '</p>
                <p class="card-text role-nama">' . $row['role_idol'] . '</p>
                <p class="card-text grup-nama my-0">' . $row['nama_grup'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

$listIdol->close();

$home = new Template('templates/skin.html');

$home->replace('DATA_IDOL', $data);
$home->write();
