<?php

class Idol extends DB
{
    function getIdolJoin()
    {
        $query = "SELECT * FROM idol JOIN role ON idol.id_role=role.id_role JOIN grup ON idol.id_grup=grup.id_grup ORDER BY idol.id";

        return $this->execute($query);
    }
    function getIdol()
    {
        $query = "SELECT * FROM idol";
        return $this->execute($query);
    }

    function getIdolById($id)
    {
        $query = "SELECT * FROM idol JOIN role ON idol.id_role=role.id_role JOIN grup ON idol.id_grup=grup.id_grup WHERE id=$id";
        return $this->execute($query);
    }

    function searchIdol($keyword)
    {
        $query = "SELECT * FROM idol JOIN role ON idol.id_role=role.id_role JOIN grup ON idol.id_grup=grup.id_grup WHERE nama LIKE '%" . $keyword . "%'";
        return $this->execute($query);
    }

    function addData($data, $file)
    {
        $tmp_file = $file['foto_idol']['tmp_name'];
        $foto_idol = $file['foto_idol']['name'];

        $dir = "assets/images/$foto_idol";
        move_uploaded_file($tmp_file, $dir);

        $nama = $data['nama'];
        $id_role = $data['id_role'];
        $id_grup = $data['id_grup'];

        $query = "INSERT INTO idol VALUES ('', '$nama', '$foto_idol', '$id_role', '$id_grup')";
        return $this->executeAffected($query);
    }

    function updateData($id, $data, $file, $img)
    {


        $tmp_file = $file['foto_idol']['tmp_name'];
        $foto_idol = $file['foto_idol']['name'];

        if ($foto_idol == "") {
            $foto_idol = $img;
        }

        $dir = "assets/images/$foto_idol";
        move_uploaded_file($tmp_file, $dir);

        $nama = $data['nama'];
        $id_role = $data['id_role'];
        $id_grup = $data['id_grup'];

        $query = "UPDATE idol SET nama = '$nama', foto_idol = '$foto_idol', id_role = '$id_role', id_grup = '$id_grup' WHERE id = '$id'";
        return $this->executeAffected($query);
    }

    function deleteData($id)
    {
        $query = "DELETE FROM idol WHERE id = $id";
        return $this->executeAffected($query);
    }

    function filterIdolAsc()
    {
        $query = "SELECT * FROM idol JOIN role ON idol.id_role=role.id_role JOIN grup ON idol.id_grup=grup.id_grup ORDER BY nama ASC";
        return $this->execute($query);
    }

    function filterIdolDesc()
    {
        $query = "SELECT * FROM idol JOIN role ON idol.id_role=role.id_role JOIN grup ON idol.id_grup=grup.id_grup ORDER BY nama DESC";
        return $this->execute($query);
    }
}
