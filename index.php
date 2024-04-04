<?php
session_start();
require "dbconnect.php";

if(!isset($_SESSION['login'])){
    $notlogin = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration and Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
    

</head>
<body>
    <header>
        <h1>F1 Merchandise Store</h1>
        <nav>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#kategori-produk">Kategori Produk</a></li>
                <li><a href="#stok-produk">Stok Produk</a></li>
                <li><a href="#admin">Admin</a></li>
            </ul>
        </nav>
    </header>
    <section class="banner">
        <img src="merch1.jpeg" width="290px">
        <div class="banner-text">
            <h2>F1 Merchandise Store Management</h2>
            <p>Nikmati berbagai produk eksklusif kami dan dukung tim-tim favorit Anda.</p>
        </div>
    </section>

    <section class="featured-products">
        <h2>Produk Terlaris</h2>
        <div class="produk">
            <div class="produk-item">
                <img src="ferrarijacket.jpg" alt="Produk 1" width="350px">
                <h3>Jacket Ferrari</h3>
                <p>Jaket andalan customer.</p>
            </div>
            <div class="produk-item">
                <img src="topi mercy.jpg" alt="Produk 2" width="350px">
                <h3>Mercy Hat</h3>
                <p>Topi yang paling sering dicari.</p>
            </div>
            <div class="produk-item">
                <img src="lewis t-shirt.jpg" alt="Produk 3" width="350px">
                <h3>LH T-Shirt</h3>
                <p>T-Shirt terlaris.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> F1 Merchandise Store</p>
    </footer>

    <section id="kategori-produk" class="kategori-produk">
        <h2>Kategori Produk</h2>
        
        <div class="kategori-item">
            <a href="#">
                <img src="leclerc tshirt.jpg" alt="Kaos" width="150">
                <p>Kaos</p>
            </a>
        </div>
        <div class="kategori-item">
            <a href="#">
                <img src="topi.jpg" alt="Topi" width="150">
                <p>Topi</p>
            </a>
        </div>
        <div class="kategori-item">
            <a href="#">
                <img src="aksesoris.jpg" alt="Aksesoris" width="150">
                <p>Aksesoris</p>
            </a>
        </div>
    </div>
    </section>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> F1 Merchandise Store</p>
    </footer>

    <section id="stok-produk">
    <h2>Stok Produk</h2>
    <?php
    // Buat koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "minpro3";

    // Buat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mengambil data stok produk
    $sql = "SELECT * FROM stok_produk";
    $result = $conn->query($sql);

    // Cek apakah ada data produk yang ditemukan
    if ($result->num_rows > 0) {
        // Tampilkan data produk
        echo "<table>";
        echo "<tr><th>ID</th><th>Nama Produk</th><th>Stok</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo 
            "<tr><td>" . $row["Id"] . 
            "</td><td>" . $row["Produk"] . 
            "</td><td>" . $row["Stok"] . 
            "</td></tr>" . $row["Harga"];
        }
        echo "</table>";
    } else {
        echo "Tidak ada stok produk yang ditemukan";
    }

    // Tutup koneksi
    $conn->close();
    ?>
</section>


    <script>
        function showLogin() {
            document.getElementById('registration').style.display = 'none';
            document.getElementById('login').style.display = 'block';
        }

        function showRegistration() {
            document.getElementById('login').style.display = 'none';
            document.getElementById('registration').style.display = 'block';
        }

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const addForm = document.getElementById('add-form');
    const productList = document.getElementById('product-list');

    addForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const name = document.getElementById('name').value;
        const price = document.getElementById('price').value;

        fetch('add_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name: name, price: price })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                getProductList();
            } else {
                alert('Gagal menambahkan produk.');
            }
        });
    });

    function getProductList() {
        fetch('get_products.php')
        .then(response => response.json())
        .then(data => {
            productList.innerHTML = '';

            data.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.id}</td>
                    <td>${product.name}</td>
                    <td>${product.price}</td>
                    <td>
                        <button onclick="updateProduct(${product.id})">Update</button>
                        <button onclick="deleteProduct(${product.id})">Delete</button>
                    </td>
                `;
                productList.appendChild(row);
            });
        });
    }

    getProductList();
});

function deleteProduct(id) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        fetch('delete_product.php?id=' + id, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                getProductList();
            } else {
                alert('Gagal menghapus produk.');
            }
        });
    }
}

function updateProduct(id) {
    const newName = prompt('Masukkan nama produk baru:');
    const newPrice = prompt('Masukkan harga produk baru:');

    if (newName && newPrice) {
        fetch('update_product.php?id=' + id, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name: newName, price: newPrice })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                getProductList();
            } else {
                alert('Gagal memperbarui produk.');
            }
        });
    }
}

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>