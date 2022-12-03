 <?php
 @session_start();
 require_once 'database.php';

if (!isset($_POST['functionname']) || !isset($_POST['arguments'])) {
  return;
}

// Extract arguments from the POST variables:
$item_id = $_POST['arguments'][0];

 $res = 'fail';

if ($_POST['functionname'] == "add_to_watchlist") {
  // TODO-DONE: Update database and return success/failure.

    pg_insert($connection, 'Watches', [
        'userid' => $_SESSION['uid'],
        'itemid' => $item_id
    ]);

  $res = "success";
}
else if ($_POST['functionname'] == "remove_from_watchlist") {
  // TODO-DONE: Update database and return success/failure.

    pg_delete($connection, 'Watches', [
        'userid' => $_SESSION['uid'],
        'itemid' => $item_id
    ]);

  $res = "success";
}

// Note: Echoing from this PHP function will return the value as a string.
// If multiple echo's in this file exist, they will concatenate together,
// so be careful. You can also return JSON objects (in string form) using
// echo json_encode($res).
 header('Content-Type: application/json; charset=utf-8');
echo json_encode(['res'=>$res]); exit;

?>
