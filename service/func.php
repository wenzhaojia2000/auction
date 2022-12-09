<?php
    require_once dirname(dirname(__FILE__)) . '../database.php';
    require_once dirname(dirname(__FILE__)) . '../utilities.php';

    function postmail($to, $subject = '', $body = '') {
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
        if (!$mail->Send()) {
            echo 'Error info:' . $mail -> ErrorInfo;
            exit();
        } else {
            return 'Success';
        }
    }

    function noticeToBidder($itemId = 0) {
        // get title of auction
        $sql = <<<SQL
            SELECT itemname FROM "Items" WHERE itemid = '$itemId'
        SQL;
        $title = fetch_row($sql)['itemname'];
        // select the bidder that had been outbidded
        $sql = <<<SQL
            SELECT "User".email, "User".userid FROM "Bid"
            INNER JOIN "User" ON "Bid".userid = "User".userid
            WHERE itemid = '$itemId' ORDER BY bidid DESC OFFSET 1 LIMIT 1
        SQL;
        $res = fetch_row($sql);
        if ($res) {
            $lastBiduid = $res['userid'];
            $lastBidEmail = $res['email'];
            // check if that user is watching the item
            $check = <<<SQL
                SELECT * FROM "Watches" WHERE itemid = '$itemId' AND userid = '$lastBiduid'
            SQL;
            $check_res = fetch_row($check);
            if ($check_res) {
                postmail($lastBidEmail,
                    'eBayDeluxe: Price of item "' . $title . '" updated',
                    'Someone has outbidded you on the item you were watching. (Name: ' . $title . ', Item ID: ' . $itemId . ')'
                );
            }
        }
    }
?>