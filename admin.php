<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'dbconnect.php';

    $db = new Database();

    if (isset($_POST['submit'])) {
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];

        $foto = $_FILES['gambar']['tmp_name'];
        $foto_name = $_FILES['gambar']['name'];
        $foto_size = $_FILES['gambar']['size'];

        if ($foto_name != "") {
            $gambar_data = file_get_contents($foto);
        } else {
            $gambar_data = null;
        }

        if ($db->tambahData($nama, $harga, $gambar_data)) {
            $success_message = "Data berhasil ditambahkan.";
        } else {
            $error_message = "Gagal menambahkan data.";
        }
    }

    if (isset($_POST['hapus'])) {
        $id_to_delete = $_POST['id_to_delete'];

        if ($db->hapusDataByID($id_to_delete)) {
            $success_message = "Data dengan ID $id_to_delete telah dihapus.";
        } else {
            $error_message = "Gagal menghapus data.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin Merchandise</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/style.css" rel="stylesheet" />

        <style>


        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; 
            color: #333; 
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px; 
            margin: 0 auto; 
            padding: 20px;
            background-color: #fff; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 30px;
        }

        input[type="text"],
        input[type="file"],
        input[type="submit"] {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        button[type="submit"] {
            padding: 8px 20px;
            background-color: #cb1726; 
            color: #fff; 
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #333;
        }

        .portfolio-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .portfolio-item img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .portfolio-item:hover img {
            transform: scale(1.05);
        }

        .portfolio-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.7);
            width: 100%;
            padding: 10px;
            color: #fff;
            font-size: 14px;
        }

        input[type="text"],
        input[type="file"],
        input[type="submit"] {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 30%;
            box-sizing: border-box;
        }

        .portfolio-hover-content {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #fff;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .portfolio-item:hover .portfolio-hover {
            opacity: 1;
        }

        .portfolio-item:hover .portfolio-hover-content {
            opacity: 1;
        }

        .portfolio-item img {
            transition: transform 0.3s ease;
        }

        .portfolio-item:hover img {
            transform: scale(1.1);
        }


        </style>

    </head>
<body>
    <h2>Tambah Data</h2>
    <?php if(isset($success_message)): ?>
        <script>
            alert("<?php echo $success_message; ?>");
        </script>
    <?php endif; ?>
    <?php if(isset($error_message)): ?>
        <script>
            alert("<?php echo $error_message; ?>");
        </script>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <input type="text" name="nama" placeholder="Nama Produk" required><br>
        <input type="text" name="harga" placeholder="Harga" required><br>
        <input type="file" name="gambar" accept="image/*"><br> 
        <button type="submit" name="submit">Tambahkan</button> 
    </form>

    <h2>Update Data</h2>
    <div class="container">
        <form action="update.php" method="post" enctype="multipart/form-data">
            <!-- Ganti "update.php" dengan alamat file yang sesuai -->
            <input type="text" name="id_to_update" placeholder="Masukkan Id produk yang ingin diupdate" required><br>
            <input type="text" name="nama_update" placeholder="Nama Produk Baru" required><br>
            <input type="text" name="harga_update" placeholder="Harga Baru" required><br>
            <input type="file" name="gambar_update" accept="image/*"><br> 
            <button type="submit" name="update">Update</button> 
        </form>
    </div>

    <h2>Hapus Data</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="id_to_delete" placeholder="Masukkan Id produk yang ingin dihapus" required><br>
        <button type="submit" name="hapus">Hapus</button>
    </form>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <div class="text-center">
            <h3 class="section-subheading text-muted">F1 Merhandise Management CRUD</h3>
        </div>
        <div class="row">
            <?php
            $con = mysqli_connect("localhost", "root", "", "minpro3_web");

            if (mysqli_connect_errno()) {
                echo "Koneksi database gagal: " . mysqli_connect_error();
            }

            $sql = "SELECT * FROM produk";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id_to_show = $row['id'];
                    $nama_produk = $row['nama'];
                    $harga = $row['harga'];
                    $foto = $row['foto'];
                    ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal<?php echo $id_to_show; ?>">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <br>
                                <br>
                                <img class="img-fluid" src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="..." />
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading"><?php echo $nama_produk; ?></div>
                                <div class="portfolio-caption-subheading text-muted"><?php echo $harga; ?></div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                echo "Tidak ada gambar yang ditemukan.";
            }
            mysqli_close($con);
            ?>
        </div>
    </div>
</section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>