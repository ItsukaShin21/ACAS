<?php
    require_once('dbconnection.php');

    if(isset($_GET['eventname'])) {
        $eventname = $_GET['eventname'];

        $sql = "SELECT * FROM attendancerecord WHERE eventname = '$eventname'";
        $list = $connection -> query($sql);
    
    if($list -> num_rows > 0) {
        echo 
            '<table id = "attendanceTable">
                <caption>'.$eventname.'</caption>
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
                                <td>'.$studentid.'</td>
                                <td>'.$name.'</td>
                                <td>'.$program.'</td>
                                <td>'.$section.'</td>
                                <td>'.$timein.'</td>
                                <td>'.$timeout.'</td>
                                <td>'.$status.'</td>
                            </tr>';
                        }
                    }
                    echo '</tbody>
                        </table>';
                    }
                    else {
                        echo '<h1 style = "text-align: center;">No record</h1>';
            }
        }
?>