<?php

class Role extends DB
{
    function getRole()
    {
        $query = "SELECT * FROM role";
        return $this->execute($query);
    }

    function getRoleById($id)
    {
        $query = "SELECT * FROM role WHERE id_role=$id";
        return $this->execute($query);
    }

    function addRole($data)
    {
        $nama = $data['nama'];
        $query = "INSERT INTO role VALUES('', '$nama')";
        return $this->executeAffected($query);
    }

    function updateRole($id, $data)
    {
        $role_idol = $data['nama'];
        $query = "UPDATE role SET role_idol = '$role_idol' WHERE id_role=$id";
        return $this->executeAffected($query);
    }

    function deleteRole($id)
    {
        $query = "DELETE FROM role WHERE id_role = $id";
        return $this->executeAffected($query);
    }

    function filterRoleAsc()
    {
        $query = "SELECT * FROM role ORDER BY role_idol ASC";
        return $this->execute($query);
    }

    function filterRoleDesc()
    {
        $query = "SELECT * FROM role ORDER BY role_idol DESC";
        return $this->execute($query);
    }

    function searchRole($keyword)
    {
        $query = "SELECT * FROM role WHERE role_idol LIKE '%" . $keyword . "%'";
        return $this->execute($query);
    }
}
