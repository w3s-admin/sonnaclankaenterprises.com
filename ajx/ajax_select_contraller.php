<?php

require_once '../cpad/clsCommonBase.php';
$cdb = new ControlPadDB();
$dbh = $cdb->dbh;
if (isset($_POST['data']) && $_POST['data'] == "main") {
    $id = (isset($_POST['id'])) ? CommonBase::decrypt($_POST['id']) : 0;
    $query = "SELECT m.Id, m.name
    FROM model m
    WHERE m.fk_make = ? 
    AND m.status = 1 ";
    $stmt2 = $dbh->prepare($query);
    $stmt2->execute(array($id));
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $vcount = "";
        $count = CommonBase::getCountByFK('fk_make', $row['Id']);
        $vcount = ($count != 0) ? "  <b>(</b> $count <b>)</b>" : "";
        $memnum = CommonBase::encrypt($row['Id']);
        $name = $row['name'];
        echo "<option value='$memnum'>$name $vcount</option>";
        // echo $name;
    }
}
?>
