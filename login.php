<?php
session_start();

if(isset($_SESSION['username'])){
    header("Location:admin.php");
}

include("db.php");
include("includes/header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $passwordInserted = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $stmt->bind_result($id, $username, $password);

    if ($stmt->fetch()) {
        if (password_verify($passwordInserted, $password)) {
            $_SESSION["username"] = $username;
            header("Location:admin.php");
        } else {
            $message = "Error: Password wrong";
        }
    } else {
        $message = "Error: Username not founded";
    }
}

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Login</h4>
                </div>
                <?php if(isset($message)){?>
                            <div class="alert alert-danger" role="alert">
                                <strong><?php echo $message; ?></strong>
                            </div>
                        <?php } ?>
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php';?>
