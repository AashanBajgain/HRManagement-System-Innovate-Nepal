<?php include('../user/header.php'); ?>


        <!-- Main Content Section Starts -->
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
                        <h1>Manage Notice</h1>
                        <a href="add-notice.php" class="btn-primary add-emp">Add Notice</a>
                    </div>
                    <div class="employee-list">
                        <div class="admin-dashboard">
                            
                            <div class="user-list-wrap box-class">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>S.N.</th>
                                            <th>Title</th>
                                            <th>Desc.</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $sql = "SELECT * FROM tbl_notice";
                                        $res = mysqli_query($conn, $sql);
                                        if($res==TRUE){
                                            $count = mysqli_num_rows($res);
                                            $sn=1;
                                            if($count>0){
                                                while($rows=mysqli_fetch_assoc($res)){
                                                    $id=$rows['id'];
                                                    $title=$rows['title'];
                                                    $description=$rows['description'];
                                                    $date=$rows['date'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sn++; ?>. </td>
                                                        <td><?php echo $title; ?></td>
                                                        <td><?php echo $description; ?></td>
                                                        <td><?php echo $date; ?></td>
                                                        <td>
                                                            <a href="<?php echo SITEURL; ?>admin/delete-notice.php?id=<?php echo $id; ?>" class="btn-danger">Delete Notice</a>
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