<?php

require_once '../cpad/clsCommonBase.php';
$cdb = new ControlPadDB();
$dbh = $cdb->dbh;

// Existing behaviour, unchanged — Model options filtered by the selected Make.
// Kept as the default/"main" mode for backward compatibility with every
// existing caller (systemadmin/vehicle_add.php, used_japanese_vehicles.php,
// index.php, new_vehicles.php all already POST data:'main').
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
    }
}

// New — Make options filtered by vehicle group ('car' or 'motorcycle'),
// used when the vehicle Type dropdown changes (Motor Bicycle vs anything else).
if (isset($_POST['data']) && $_POST['data'] == "make_by_group") {
    $group = ($_POST['group'] ?? 'car') === 'motorcycle' ? 'motorcycle' : 'car';
    $query = "SELECT Id, name FROM make WHERE status = 1 AND vehicle_group = ? ORDER BY name ASC";
    $stmt2 = $dbh->prepare($query);
    $stmt2->execute(array($group));
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $memnum = CommonBase::encrypt($row['Id']);
        $name = $row['name'];
        echo "<option value='$memnum'>$name</option>";
    }
}

// New — Body Type options filtered by vehicle group, same trigger as above.
if (isset($_POST['data']) && $_POST['data'] == "bodytype_by_group") {
    $group = ($_POST['group'] ?? 'car') === 'motorcycle' ? 'motorcycle' : 'car';
    $query = "SELECT Id, name FROM body_type WHERE status = 1 AND vehicle_group = ? ORDER BY name ASC";
    $stmt2 = $dbh->prepare($query);
    $stmt2->execute(array($group));
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $memnum = CommonBase::encrypt($row['Id']);
        $name = $row['name'];
        echo "<option value='$memnum'>$name</option>";
    }
}
?>
