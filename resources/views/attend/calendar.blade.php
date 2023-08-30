<?php
$DAYS = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
$DAYS_LEAP = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
$DAYS_OF_THE_WEEK = ['일','월', '화', '수', '목', '금', '토'];
$MONTHS = ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'];

$ACTIVE1 = "active_blue "; // 출석(홀수월)
$ACTIVE2 = "active_red "; // 출석(짝수월)
$DOT1 = "dot1 "; // 등원
$DOT2 = "dot2 "; // 하원
$NOTICE = "notice "; // 공지

$ym = $_POST['ym'] ?? '0';
$attendListBlue = $_POST['attendListBlue'] ?? [];
$attendListRed = $_POST['attendListRed'] ?? [];
$attendIn = $_POST['attendIn'] ?? [];
$attendOut = $_POST['attendOut'] ?? [];
$infoDates = $_POST['infoDates'] ?? [];

$today = $ym ? strtotime($ym) : time();
$date = $today;
$month = date('n', $date);
$year = date('Y', $date);
$startDay = date('w', strtotime($year.'-'.$month.'-01'));

if(date('L', $date) == 1) {
    $days = $DAYS_LEAP;
} else {
    $days = $DAYS;
}

$dateHtml = '';

for($i=0; $i < $days[$month-1]+$startDay; $i++) {
    $d = $i - ($startDay - 1);
    $nowDay = ($month).'.'.$d;
    
    if($d > 0) {
        $className = "";

        if(in_array($d, $attendListBlue)) {
            $className .= $ACTIVE1;
        } else if(in_array($d, $attendListRed)) {
            $className .= $ACTIVE2;
        }
        
        if(in_array($d, $attendIn)) {
            $className .= $DOT1;
        }
        if(in_array($d, $attendOut)) {
            $className .= $DOT2;
        }
        if(in_array($d, $infoDates)) {
            $className .= $NOTICE;
        }

        $dateHtml .= 
            '<li>
                <div class="'.$className.'">
                <p class="fs_16 fw_700">'.$d.'</p>
                </div></li>
            </li>';
    } else {
        $dateHtml .= '<li></li>';
    }
}

$result = new stdClass();
$result->calHtml = $dateHtml;
$result->year = $year;
$result->month = $MONTHS[$month-1];

echo json_encode($result);

?>