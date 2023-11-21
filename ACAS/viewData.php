<?php
    require_once('dbconnection.php');

    if(isset($_GET['eventname'])) {
        $eventname = $_GET['eventname'];

        $sql = "SELECT * FROM attendancerecord WHERE eventname = '$eventname'
        ORDER BY updated_at DESC";

        $list = $connection -> query($sql);
    
    if($list -> num_rows > 0) {
        echo 
            '<form method = "POST">
            <table id = "attendanceTable">
                <thead>
                    <th class = "idHead">ID number</th>
                    <th class = "nameHead">Name</th>
                    <th class = "programHead">Program</th>
                    <th class = "sectionHead">Section</th>
                    <th class = "timeHead">Time In</th>
                    <th class = "timeHead">Time Out</th>
                    <th class = "">Status</th>
                </thead>
                <tbody>';
                    while($row = $list -> fetch_assoc()) {
                        $studentid = $row['studentid'];
                        $timein = $row['timein'];
                        $timeout = $row['timeout'];
                        $status = $row['status'];
                        
                        $sqlstudent = "SELECT * FROM students WHERE studentid = '$studentid'";
                        $result = $connection->query($sqlstudent);
                        
                        while($row1 = $result->fetch_assoc()) {
                            $studentid = $row1['studentid'];
                            $name = $row1['name'];
                            $section = $row1['section'];
                            $program = $row1['program'];

                            echo
                            '<tr>
                                <td name = "studentid">'.$studentid.'</td>
                                <td>'.$name.'</td>
                                <td>'.$program.'</td>
                                <td>'.$section.'</td>
                                <td name = "timeIn" class="clickable" onclick="handleClick(event)">'.$timein.'</td>
                                <td name = "timeOut" class="clickable" onclick="handleClick(event)">'.$timeout.'</td>
                                <td>'.$status.'</td>
                            </tr>';
                        }
                    }
                    echo '</tbody>
                        </table>
                        <form>';
                    }
                    else {
                        echo '<div class = "norecordDisplay"><p>No record</p></div>';
            }
        }
?>