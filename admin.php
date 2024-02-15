<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location:login.php");
}

include("db.php");
include("includes/header.php");

// GetAll Apis 
$stmt = $conn->prepare("SELECT id, api_name, url FROM apis");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $apiName, $url);
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12 text-end bg-dark p-2">
            <div class="dropdown">
            <a class="btn btn-warning dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="me-2"><?=$_SESSION['username'];?></span>
                <i class="fa-solid fa-user"></i>
            </a>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <table id="api-table" class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Api Name</th>
                        <th>Url</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="api-tbody">
                    <?php
                    while ($stmt->fetch()) { ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $apiName; ?></td>
                            <td><?php echo $url; ?></td>
                            <td>
                                <a href="#" class="btn btn-secondary" onclick="editApi(<?php echo $row['id']; ?>)">
                                    <i class="fas fa-marker"></i>
                                </a>
                                <a href="#" class="btn btn-danger" onclick="deleteApi(<?php echo $row['id']; ?>)">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <div class="card card-body">
                <h2 id="title-form" class="mb-2">Insert Api</h2>
                <form id="api-form" method="POST">
                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="id" id="idInput">
                    </div>
                    <div class="form-group mb-3">
                        <label for="apiName">Api Name</label>
                        <input type="text" id="apiName" name="apiName" class="form-control" placeholder="Enter Api Name" required>
                    </div>
                    <div class="form-group mb-3">
                    <label for="url">Url</label>
                        <input type="url" id="url" name="url" class="form-control" placeholder="Enter Url" required>
                    </div>
                    <input type="submit" class="btn btn-success btn-block" value="Save">
                    <button id="cancel" type="button" class="btn btn-danger btn-block d-none" onclick="cancelEdit()">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php';?>