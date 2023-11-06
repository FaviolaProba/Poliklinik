<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Terima data dari formulir registrasi
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    try {
        // Gantilah dengan pengaturan koneksi database Anda
        $db = new PDO("mysql:host=localhost;dbname=poliklinik", "root", "");

        // Contoh pengecekan apakah username sudah digunakan sebelumnya
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user_count = $stmt->fetchColumn();

        if ($user_count > 0) {
            $registration_error = "Username sudah digunakan. Silakan pilih username lain.";
        } else {
            // Simpan data pengguna ke database
            $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$username, $password, $role]);

            $registration_success = "Registrasi berhasil. Silakan login.";
            echo '<p class="mt-3 text-center">Sudah memiliki akun? <a href="login.php">Silakan Login</a></p>';
        }
    } catch (PDOException $e) {
        echo "Koneksi database gagal: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7Rxnatzjc...<!-- Tambahkan URL CSS Bootstrap yang sesuai --">
</head>
<body style="background-color: #f4f4f4;">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Register</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" placeholder="Username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" placeholder="Password">
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role">
                                    <option value="dokter">Dokter</option>
                                    <option value="pasien">Pasien</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                    </div>
                </div>
                <?php
                if (isset($registration_error)) {
                    echo '<div class="alert alert-danger mt-3" role="alert">' . $registration_error . '</div>';
                }
                if (isset($registration_success)) {
                    echo '<div class="alert alert-success mt-3" role="alert">' . $registration_success . '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhc...<!-- Tambahkan URL JavaScript Bootstrap yang sesuai -->
</body>
</html>