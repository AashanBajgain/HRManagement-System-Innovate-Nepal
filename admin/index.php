<?php include('../user/header.php'); ?>
<div class="admin-dashboard">
    <div class="wrapper">
        <?php include('sidebar.php'); ?>
        <div class="main-body">
            <div class="wrapper">
                <div class="row">
                    <div class="col-lg-12 pb-3">
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
                    <div class="col-lg-6">
                        <div class="left-section">
                            <div class="leave-section">
                                <h3>Requested Leave</h3>
                                <div class="request-list">
                                    <ul>
                                        <?php 
                                        $leavesql = "SELECT * FROM tbl_leave";
                                        //Execute the Query
                                        $leaveres=mysqli_query($conn, $leavesql);
                                        //Count Rows
                                        $count = mysqli_num_rows($leaveres);
                                        //CHeck whether the foods are availalable or not
                                        if($count>0)
                                        {
                                            while($row=mysqli_fetch_assoc($leaveres))
                                            {
                                                //Get the Values
                                                $uid = $row['uid'];
                                                $namesql = "SELECT full_name FROM tbl_admin WHERE id = $uid";
                                                $nameres = mysqli_query($conn, $namesql);
                                                //Count Rows
                                                $rowname = mysqli_fetch_assoc($nameres);
                                        ?>
                                        <li class="<?php if($row['approved']==1){ echo 'approved';} ?>">
                                            <a href="<?php if($row['approved']==1){ echo '#'; }else{ echo SITEURL; ?>admin/update-leaverequest.php?id=<?php echo $row['id']; } ?>">
                                                <div class="left">
                                                    <span class="name"><?php echo $rowname['full_name']; ?></span>
                                                </div>
                                                <div class="right">
                                                    <span class="des"><?php echo $row['reason'];?></span>
                                                    <span class="date"><?php echo $row['date'];?></span>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
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

