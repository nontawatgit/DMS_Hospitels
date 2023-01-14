<?php
header("Content-type:application/json; charset=UTF-8");    
header("Cache-Control: no-store, no-cache, must-revalidate");         
header("Cache-Control: post-check=0, pre-check=0", false); 
// โค้ดไฟล์ dbconnect.php ดูได้ที่ http://niik.in/que_2398_5642
 require_once("dbconnect.php");
$json_data = array();
 
$sql ="
SELECT * FROM tb_ap WHERE ap_startdate>='".$_GET['start']."'
AND ap_enddate<='".$_GET['end']."'
";
$result = $mysqli->query($sql);
if(isset($result) && $result->num_rows>0){
    while($row = $result->fetch_assoc()){
        $_start_date = $row['ap_startdate'];
        $_end_date = false;
        $_start_time = false;
        $_end_time = false;
        $_repeat_day = false;

        if($row['ap_starttime']!="00:00:00"){
            $_start_date = $row['ap_startdate']."T".$row['ap_starttime'];
            if($row['ap_endtime']!="00:00:00" && ($row['ap_starttime']==$row['ap_enddate'] || 
            $row['ap_enddate']=="0000-00-00") ){
                $_end_date = $row['ap_startdate']."T".$row['ap_endtime'];
            }
        }
        if($row['ap_enddate']!="0000-00-00"){
            $_end_date = $row['ap_enddate'];
            if($row['ap_endtime']!="00:00:00"){
                $_end_date = $row['ap_enddate']."T".$row['ap_endtime'];
            }else{
                $_end_date = date("Y-m-d",strtotime($row['ap_enddate']." +1 day"));
            }
        }
        if($row['ap_enddate']!="0000-00-00" && $row['ap_enddate']!=$row['ap_startdate'] 
        && $row['ap_starttime']!="00:00:00" && $row['ap_endtime']!="00:00:00" ){
            $_start_date = $row['ap_startdate'];
            $_end_date = $row['ap_enddate'];             
            $_start_time = $row['ap_starttime'];
            $_end_time = $row['ap_endtime'];     
         
        }
        // ทำการเปลี่ยน หรือกำหนดการใช้งาน url หรือลิ้งค์ เป็นการเรียกใช้งาน javascript ฟังก์ชั่น
        $row['ap_url'] = "javascript:viewdetail('{$row['ap_id']}');"; // ส่งค่า id ไปในฟังก์ชั่น
        $arr_eventData = array(
            "id" => $row['ap_id'],
            "groupId" => str_replace("-","",$row['ap_startdate']),
            "start" => $_start_date,
            "end" => $_end_date,
            "startTime" => $_start_time,
            "endTime" => $_end_time,
            "title" => $row['ap_title'],
            "url" => $row['ap_url'],
            "textColor" => $row['ap_text_color'],
            "backgroundColor" => $row['ap_bg_color'],
            "borderColor" => "transparent",
            "detail" => $row['ap_detail'],// กำหนดฟิลด์เพิ่มเติมที่จะใช้งานข้อมูล
        );
           
        if($row['ap_enddate']!="0000-00-00" && $row['ap_enddate']!=$row['ap_startdate'] 
        && $row['ap_starttime']!="00:00:00" && $row['ap_endtime']!="00:00:00" ){
            $arr_eventData['startRecur'] = $_start_date;
            $_end_date = date("Y-m-d",strtotime($row['ap_enddate']." +1 day"));
            $arr_eventData['endRecur'] = $_end_date;
        }

        if(!$_end_date){unset($arr_eventData['end']);}
        if(!$_start_time){unset($arr_eventData['startTime']);}
        if(!$_end_time){unset($arr_eventData['endTime']);}
        $json_data[] = $arr_eventData;
    }
}
// แปลง array เป็นรูปแบบ json string  
if(isset($json_data)){  
    $json= json_encode($json_data);    
    if(isset($_GET['callback']) && $_GET['callback']!=""){    
    echo $_GET['callback']."(".$json.");";        
    }else{    
    echo $json;    
    }    
}
?>