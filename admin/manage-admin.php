<?php include('../user/header.php'); ?>

        <div class="main-content admin-dashboard">
            <div class="wrapper">
                <?php include('sidebar.php'); ?>
                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add']; //Displaying Session Message
                        unset($_SESSION['add']); //REmoving Session Message
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }
                    
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                    }

                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo $_SESSION['pwd-not-match'];
                        unset($_SESSION['pwd-not-match']);
                    }

                    if(isset($_SESSION['change-pwd']))
                    {
                        echo $_SESSION['change-pwd'];
                        unset($_SESSION['change-pwd']);
                    }

                ?>
                <div class="manage-employee">
                    <div class="top-emp-sec">
                        <h1>Manage Employee</h1>
                        <a href="add-admin.php" class="btn-primary add-emp">Add Employee</a>
                    </div>
                    <div class="employee-list">
                        <div class="admin-dashboard">
                            
                            <div class="user-list-wrap box-class">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>S.N.</th>
                                            <th>Full Name</th>
                                            <th>Role</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $sql = "SELECT tbl_admin.*, tbl_employeetype.title FROM tbl_admin JOIN tbl_employeetype ON tbl_admin.employeetype = tbl_employeetype.id";
                                        $res = mysqli_query($conn, $sql);
                                        if($res==TRUE){
                                            $count = mysqli_num_rows($res);
                                            $sn=1;
                                            if($count>0){
                                                while($rows=mysqli_fetch_assoc($res)){
                                                    $id=$rows['id'];
                                                    $full_name=$rows['full_name'];
                                                    $emptitle=$rows['title'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sn++; ?>. </td>
                                                        <td><?php echo $full_name; ?></td>
                                                        <td><?php echo $emptitle; ?></td>
                                                        <td>
                                                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>