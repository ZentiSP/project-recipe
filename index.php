<?php

session_start();
require_once "config/db.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Website</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <!-- Modal add user -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="insert.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3 row g-2">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="firstname" placeholder="" required>
                                    <label for="firstname" class="col-form-label">First Name</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="lastname" placeholder="" required>
                                    <label for="lastname" class="col-form-label">Last Name</label>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="mb-3">
                <label for="firstname" class="col-form-label">First Name:</label>
                <input type="text" class="form-control" name="firstname" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="col-form-label">Last Name:</label>
                <input type="text" class="form-control" name="lastname" required>
            </div> -->
                        <div class="mb-3 form-floating">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                                name="classyear" required>
                                <option selected>Select your class year</option>
                                <option value="1">Year 1</option>
                                <option value="2">Year 2</option>
                                <option value="3">Year 3</option>
                                <option value="4">Year 4</option>
                            </select>
                            <label for="classyear" class="col-form-label">Year</label>
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="col-form-label">Brithday</label>
                            <input type="date" class="form-control" name="birthday" required>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="col-form-label">Picture</label>
                            <input type="file" class="form-control" id="imginput" name="img" required>
                        </div>
                        <img width=85% id="previewimg" alt="" class="rounded mx-auto d-block mb-3">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>CRUD Website</h1>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">Add
                    User</button> <!-- ปุ่มเพิ่มผู้ใช้-->
            </div>
        </div>
    </div>
    <div>
        <hr>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>
    </div>

    <div class="container mt-5">
        <!-- Table data -->
    <table class="table mt-5 table-bordered">
        <thead class="table-primary">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Firstname</th>
                <th scope="col">Lastname</th>
                <th scope="col">Classyear</th>
                <th scope="col">Birthday</th>
                <th scope="col">Image</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sm = $conn->query("SELECT * FROM user");
            $sm->execute();
            $users = $sm->fetchAll();

            if (!$users) {
                echo "<tr><td colspan='6' class='text-center'>No User data found</td></tr>";
            } else {
                foreach ($users as $user) {
                    ?>
                    <tr>
                        <th scope="row"><?= $user['id'];?></th>
                        <td><?= $user['firstname'];?></td>
                        <td><?= $user['lastname'];?></td>
                        <td><?= $user['classyear'];?></td>
                        <td><?= $user['birthday'];?></td>
                        <td width="150px"> <img width="100%" src="uploads/<?= $user['img'];?>"</td>
                    </tr>
                <?php }
            }
            ?>
        </tbody>
    </table>
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