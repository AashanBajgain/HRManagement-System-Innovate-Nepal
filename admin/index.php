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
                                <h3>Users Attendence</h3>
                            </div>
                            <div class="user-list-wrap box-class table-responsive">
                                <?php
                                    // Get distinct user IDs from tbl_dailylog
                                    $sql_uid = "SELECT DISTINCT uid FROM tbl_dailylog";
                                    $result_uid = mysqli_query($conn, $sql_uid);
                                    // Array to store data for each user
                                    $data = array();
                                    // Iterate over the user IDs
                                    while ($row_uid = mysqli_fetch_assoc($result_uid)) {
                                        $user_id = $row_uid['uid'];
                                        // Get the user's full name from tbl_admin
                                        $sql_full_name = "SELECT full_name FROM tbl_admin WHERE id = $user_id";
                                        $result_full_name = mysqli_query($conn, $sql_full_name);
                                        $row_full_name = mysqli_fetch_assoc($result_full_name);
                                        $full_name = $row_full_name['full_name'];
                                        
                                        // Get today's date
                                        $today = new DateTime();
                                        $last_30_days_date_array = array();
                                        // Loop to generate dates for the last 30 days
                                        for ($i = 1; $i <= 30; $i++) {
                                            // Clone today's date and subtract $i days to get the date for the past
                                            $date = clone $today;
                                            $date->modify("-$i day");
                                            // Format the date
                                            $last_30_days_date = $date->format('Y-m-d');
                                            $last_30_days_date_array[] = $date->format('j M');

                                            // Execute the SQL query for the current date and user ID
                                            $sql = "SELECT COUNT(*) AS count_records
                                                    FROM tbl_dailylog
                                                    WHERE uid = $user_id
                                                    AND date = '$last_30_days_date'
                                                    GROUP BY uid"; // Group by uid
                                            $result = mysqli_query($conn, $sql);

                                            // Fetch the count
                                            $row1 = mysqli_fetch_assoc($result);
                                            $count1 = isset($row1['count_records']) ? $row1['count_records'] : 0;

                                            // Add the count to the data array
                                            $data[$user_id]['full_name'] = $full_name;
                                            $data[$user_id]['counts'][] = $count1;
                                        }
                                    }
                                ?>
                                <table class="graph">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <?php foreach($last_30_days_date_array as $eachdate){?>
                                            <th><?php echo $eachdate;?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($data as $user_id => $counts) { 
                                        ?>
                                        <tr>
                                            <td><?php echo $counts['full_name']; ?></td>
                                            <?php foreach ($counts['counts'] as $count) { ?>
                                            <td><?php echo "<div class='bar " . ($count == 1 ? 'presence-1' : '') . "'></div>"; ?></td>
                                            <?php } ?>
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

<style>
        
</style>

