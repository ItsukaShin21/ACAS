<?php
    require_once('dbconnection.php');

    $sqlqueryView = "SELECT * FROM attendancerecord";
    $list = $connection -> query($sqlqueryView);
    
    if($list -> num_rows > 0) {
        echo 
            '<table>
                <thead>
                    <th class = "numberHead">No.</th>
                    <th class = "idHead">ID number</th>
                    <th class = "nameHead">Name</th>
                    <th class = "programHead">Program</th>
                    <th class = "timeHead">Time In</th>
                </thead>
                <tbody>';
                    while($row = $list -> fetch_assoc()) {
                        $idnumber = $row['idnumber'];
                        $name = $row['name'];
                        $program = $row['program'];
                        $timein = $row['timein'];

                        echo
                            '<tr>
                                <td>'.$idnumber.'</td>
                                <td>'.$idnumber.'</td>
                                <td>'.$name.'</td>
                                <td>'.$program.'</td>
                                <td>'.$timein.'</td>
                            </tr>';
                        }
                        echo '</tbody>
                            </table>';
                    }
                    else {
                        echo '0 record';
            }
            $connection -> close();
?>