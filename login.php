<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Terima data dari formulir login
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Gantilah dengan pengaturan koneksi database Anda
        $db = new PDO("mysql:host=localhost;dbname=poliklinik", "root", "");

        // Verifikasi data pengguna di database
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        $user = $stmt->fetch();

        if ($user) {
            // Autentikasi berhasil
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['ROLE'] = $user['ROLE'];

            if ($user['ROLE'] === 'dokter') {
                header('Location: index.php');
            } else if ($user['role'] === 'pasien') {
                header('Location: index.php');
            } else {
                // Handle roles lainnya
            }
        } else {
            $login_error = "Login gagal. Username atau password salah.";
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
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7Rxnatzjc...<!-- Tambahkan URL CSS Bootstrap yang sesuai --">
</head>
<body style="background-color: #f4f4f4;">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Login</h3>
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
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
                <?php
                if (isset($login_error)) {
                    echo '<div class="alert alert-danger mt-3" role="alert">' . $login_error . '</div>';
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhc...<!-- Tambahkan URL JavaScript Bootstrap yang sesuai -->
</body>
</html>