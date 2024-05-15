<?php include('../user/header.php'); ?>
<div class="admin-dashboard">
    <div class="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="main-body">
            <div class="wrapper">
                <div class="row">
                    <div class="col-lg-9 pb-3">
                        <div class="admin-dashboard">
                            <div class="graph-title">
                                <h3>Users activity list</h3>
                            </div>
                            <div class="user-list-wrap box-class">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Total work hour</th>
                                            <th>Total earning</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $userlistq = "SELECT tbl_admin.full_name, tbl_employeetype.title, SUM(tbl_dailylog.totaltime) AS sum_totaltime, SUM(tbl_dailylog.todayearning) AS sum_todayearning FROM tbl_dailylog JOIN tbl_admin ON tbl_dailylog.uid = tbl_admin.id JOIN tbl_employeetype ON tbl_admin.employeetype = tbl_employeetype.id GROUP BY tbl_admin.full_name, tbl_employeetype.title";
                                            $resuserlist = mysqli_query($conn, $userlistq);
                                            $i=0; while($row=mysqli_fetch_assoc($resuserlist)){ $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><span><?php echo $row['full_name'];?></span></td>
                                            <td><span><?php echo $row['title'];?></span></td>
                                            <td><span><?php echo $row['sum_totaltime'];?></span></td>
                                            <td><span>$<?php echo $row['sum_todayearning'];?></span></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="right-section box-class">
                            <h3>Today leave list</h3>
                            <?php
                                $leavelist ="SELECT tbl_leave.*, tbl_admin.full_name FROM tbl_leave JOIN tbl_admin ON tbl_leave.uid = tbl_admin.id WHERE DATE(tbl_leave.date) = CURDATE() AND tbl_leave.approved = 1"; 
                                $resleavelist = mysqli_query($conn, $leavelist);
                                $count = mysqli_num_rows($resleavelist);
                                if($count>0){
                            ?>
                            <ul>
                                <?php while($row=mysqli_fetch_assoc($resleavelist)){ ?>
                                <li>
                                    <span><?php echo $row['full_name']; ?> is on <?php echo $row['reason']; ?> leave</span>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php }else{ ?>
                                <p>All staff working today.</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

