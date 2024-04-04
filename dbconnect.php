<?php
class Database {
    private $con;

    public function __construct() {
        $this->con = mysqli_connect("localhost", "root", "", "minpro3_web");

        if (mysqli_connect_errno()) {
            echo "Koneksi database gagal: " . mysqli_connect_error();
            exit();
        }
    }

public function tambahData($nama, $harga, $gambar_data) {
    $id = 1; 
    while ($this->idExists($id)) {
        $id++; 
    }

    $sql = "INSERT INTO produk (id, nama, harga, foto) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($this->con, $sql);
    mysqli_stmt_bind_param($stmt, "isss", $id, $nama, $harga, $gambar_data);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        return true;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}

private function idExists($id) {
    $stmt = mysqli_prepare($this->con, "SELECT id FROM produk WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    return $num_rows > 0;
}


    public function getAllData() {
        $result = mysqli_query($this->con, "SELECT * FROM produk");
        $data = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function getDataByID($id) {
        $stmt = mysqli_prepare($this->con, "SELECT * FROM produk WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        return $data;
    }

    public function checkIDExist() {
        $check_query = "SELECT id FROM produk WHERE id = LAST_INSERT_ID()";
        $check_result = mysqli_query($this->con, $check_query);
        return $check_result;
    }

    public function hapusDataByID($id) {
        $sql = "DELETE FROM produk WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true; 
        } else {
            return false; 
        }
    }
}