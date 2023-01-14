
<?php 
    header('Content-Type: application/json');

    require_once 'connect_db.php';

    $sqlQuery = "SELECT * FROM tb_gen WHERE userid_gen = userid_gen";
    $result = mysqli_query($conn, $sqlQuery);

    $data = array();
    foreach ($result as $row) {
        $data[] = $row;
    }

    mysqli_close($conn);

    echo json_encode($data);

?>
