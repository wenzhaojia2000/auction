<?php

    require_once dirname(dirname(__FILE__)) . '../database.php';

    function refreshAllBid()
    {
        global $connection;

        $now = date('Y-m-d H:i:s');
        $sql = <<<SQL
select "User".email,"Items".* from "Items" 
inner join "User" on "Items".userid = "User".userid
where enddate < '{$now}' and itemid not in (
select itemid from "Sells"
) and currentprice > 0 and reservationprice <= currentprice
SQL;
        $res = fetch_all($sql);

        foreach ($res as $item) {
            $bid_sql = <<<SQL
select "User".email,"Bid".* from "Bid"
inner join "User" on "Bid".userid = "User".userid
 where itemid = {$item['itemid']} order by bidprice desc limit 1
SQL;
            $bid_res = fetch_row($bid_sql);

            $user = $item['email'];
            $bid_user = $bid_res['email'];

            pg_insert($connection, 'Sold', [
                'itemid' => $item['itemid'],
                'userid' => $bid_res['userid']
            ]);


            postmail($user, 'Auction Message' , 'Your item has been auctioned out, ItemId is ' . $item['itemid']);

            postmail($bid_user, 'Auction Message' , 'Bid Success, ItemId is ' . $item['itemid']);


        }
    }

    function noticeToBidder($itemId = 0)
    {
        $sql = <<<SQL
select "User".email from "Bid"
inner join "User" on "Bid".userid = "User".userid
 where itemid = '$itemId' order by bidid desc limit 1
SQL;

        $res = fetch_row($sql);

        $lastedBidEmail = $res['email'];

        postmail($lastedBidEmail, 'Auction Message', 'The price of the item you are bidding on has been updated;ItemId is ' . $itemId);
    }

    function postmail($to, $subject = '',$body = ''){
        error_reporting(E_ALL);
        ini_set('display_errors', true);
        $path = dirname(__FILE__);
        require_once $path.'/mail/Exception.php';
        require_once $path.'/mail/PHPMailer.php';
        require_once $path.'/mail/SMTP.php';
        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->CharSet    = 'UTF-8';
        $mail->IsSMTP();
        $mail->SMTPDebug  = 1;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host       = 'smtp.163.com';
        $mail->Port       = '465';
        $mail->Username   = 'ebaydeluxe@163.com';
        $mail->Password   = 'FOYCWQSQYDZCPINO';
        $mail->SetFrom('ebaydeluxe@163.com', 'Admin');
        $mail->Subject    = $subject;
        $mail->MsgHTML($body);
        $address = $to;
        $mail->AddAddress($address, '');
        if(!$mail->Send()) {
            echo  'error info:'.$mail->ErrorInfo;exit;
        } else {
            return 'success';
        }
    }
?>
