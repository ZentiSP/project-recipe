<?php

session_start();
require_once "config/db.php";

if (isset($POST['update'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $classyear = $_POST['classyear'];
    $birthday = $_POST['birthday'];
    $img = $_FILES['img'];

    $img2 = $_POST['img2'];
    $upload = $_FILES['img']['name'];

    if ($upload != '') {
        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode(".", $img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;
        $filePath = "uploads/" . $fileNew;

        if (in_array($fileActExt, $allow)) {
            if ($img['size'] > 0 && $img['error'] == 0) {
                move_uploaded_file($img['tmp_name'], $filePath);
            }
        }
    } else {
        $fileNew = $img2;
    }

    $sql = $conn->prepare("UPDATE user SET firstname = :firstname, lastname = :lastname, classyear = :classyear, birthday = :birthday, img = :img WHERE id = :id");
    $sql->bindParam(":firstname", $firstname);
    $sql->bindParam(":lastname", $lastname);
    $sql->bindParam(":classyear", $classyear);
    $sql->bindParam(":birthday", $birthday);
    $sql->bindParam(":img", $fileNew);
    $sql->execute();
    if ($sql) {
        $_SESSION['success'] = "Data has been updated Succesfully";
        header("location: index.php");
    } else {
        $_SESSION['error'] = "Data has not been updatedd Succesfully";
        header("location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Website</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .container {
            max-width: 550px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Data</h1>
        <hr>
        <form action="edit.php" method="post" enctype="multipart/form-data">
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $stmt = $conn->query("SELECT * FROM user WHERE id = $id");
                $stmt->execute();
                $data = $stmt->fetch();
            }
            ?>
            <div class="mb-3 row g-2">
                <input type="text" class="form-control" name="id" value="<?= $data['id'] ?>" readonly>
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="firstname" value="<?= $data['firstname'] ?>"
                            required>
                        <label for="firstname" class="col-form-label">First Name</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="lastname" value="<?= $data['lastname'] ?>"
                            placeholder="" required>
                        <label for="lastname" class="col-form-label">Last Name</label>
                    </div>
                </div>
            </div>

            <div class="mb-3 form-floating">
                <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                    name="classyear" value="<?= $data['classyear'] ?>" required>
                    <option selected>Current Year:
                        <?= $data['classyear'] ?>"
                    </option>
                    <option value="1">Year 1</option>
                    <option value="2">Year 2</option>
                    <option value="3">Year 3</option>
                    <option value="4">Year 4</option>
                </select>
                <label for="classyear" class="col-form-label">Year</label>
            </div>
            <div class="mb-3">
                <label for="birthday" class="col-form-label">Brithday</label>
                <input type="date" class="form-control" name="birthday" value="<?= $data['birthday'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="img" class="col-form-label">Picture:</label>
                <input type="file" class="form-control" id="imginput" name="img">
                <img width="100%" src="uploads/<?php echo $data['img']; ?>" id="previewimg" alt="">
            </div>
            <div class="modal-footer">
                <a href="index.php" class="btn btn-secondary">Go Back</a>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        let imginput = document.getElementById('imginput');
        let previewImg = document.getElementById('previewimg');

        imginput.onchange = evt => {
            const [file] = imginput.files;
            if (file) {
                previewimg.src = URL.createObjectURL(file);
            }
        }
    </script>
</body>

</html>