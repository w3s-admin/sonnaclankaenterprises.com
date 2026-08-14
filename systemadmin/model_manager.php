<?
require_once '../cpad/clsCommonBase.php';
require_once '../cpad/clsLookup.php';
CommonBase::IsAdminUser();

$table = 'model';
$statusCol = 'status';
$errmsg = '';
$msg = '';

if (isset($_POST['lookup_add_btn'])) {
    $name = trim($_POST['name'] ?? '');
    $fkMake = $_POST['fk_make'] ?? '';
    if ($name === '' || !is_numeric($fkMake)) {
        $errmsg = 'Name and Make are required.';
    } else {
        Lookup::add($table, array('name' => $name, 'fk_make' => $fkMake, $statusCol => 1));
        $msg = 'Model added.';
    }
}

if (isset($_POST['lookup_update_btn'])) {
    $id = CommonBase::decrypt($_POST['edit_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $fkMake = $_POST['fk_make'] ?? '';
    if (is_numeric($id) && $name !== '' && is_numeric($fkMake)) {
        Lookup::update($table, $id, array('name' => $name, 'fk_make' => $fkMake));
        $msg = 'Model updated.';
    }
}

if (isset($_POST['lookup_delete_btn'])) {
    $id = CommonBase::decrypt($_POST['del_id'] ?? '');
    if (is_numeric($id)) {
        Lookup::softDelete($table, $id, $statusCol);
        CommonBase::SendRedirect('model_manager.php');
        exit;
    }
}

$editRow = null;
if (isset($_GET['edit'])) {
    $editId = CommonBase::decrypt($_GET['edit']);
    if (is_numeric($editId)) {
        $editRow = Lookup::getById($table, $editId);
    }
}

$makes = Lookup::getAll('make', 'status', 'vehicle_group');

$cdb = new ControlPadDB();
$dbh = $cdb->dbh;
$rows = $dbh->query("SELECT model.Id, model.name, model.fk_make, make.name as make_name
    FROM model
    JOIN make ON make.Id = model.fk_make
    WHERE model.status = 1
    ORDER BY make.name ASC, model.name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <? include_once './inc/comman_head_admin.php'; ?>
    </head>
    <body>
        <div id="qLoverlay"></div>
        <div id="qLbar"></div>

        <? include_once './inc/pagehead.php'; ?>

        <div id="wrapper">
            <div class="resBtn"><a href="#"><span class="icon16 minia-icon-list-3"></span></a></div>

            <? include_once './inc/slideBar.php'; ?>

            <div id="content" class="clearfix">
                <div class="contentwrapper">

                    <div class="heading">
                        <h3>Model Manager</h3>
                        <ul class="breadcrumb">
                            <li>You are here:</li>
                            <li>Vehicle Attributes</li>
                            <li class="active">Model Manager</li>
                        </ul>
                    </div>

                    <div class="row-fluid">
                        <div class="span4">
                            <div class="admin-card">
                                <h4 style="margin-top:0;"><?= $editRow ? 'Edit Model' : 'Add New Model' ?></h4>
                                <?php if ($errmsg): ?><div class="alert alert-error"><?= htmlspecialchars($errmsg) ?></div><?php endif; ?>
                                <?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
                                <form method="post">
                                    <?php if ($editRow): ?>
                                    <input type="hidden" name="edit_id" value="<?= CommonBase::encrypt($editRow['Id']) ?>">
                                    <?php endif; ?>
                                    <div class="control-group">
                                        <label class="form-label">Make</label>
                                        <select name="fk_make" class="span12" required>
                                            <option value="">Select Make</option>
                                            <?php foreach ($makes as $mk): ?>
                                            <option value="<?= $mk['Id'] ?>" <?= (isset($editRow['fk_make']) && $editRow['fk_make'] == $mk['Id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($mk['name']) ?> (<?= $mk['vehicle_group'] === 'motorcycle' ? 'Motor Bicycle' : 'Car' ?>)
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="control-group">
                                        <label class="form-label">Model Name</label>
                                        <input type="text" name="name" class="span12" value="<?= htmlspecialchars($editRow['name'] ?? '') ?>" required>
                                    </div>
                                    <br>
                                    <button type="submit" name="<?= $editRow ? 'lookup_update_btn' : 'lookup_add_btn' ?>" class="btn btn-admin-primary">
                                        <?= $editRow ? 'Update' : 'Add Model' ?>
                                    </button>
                                    <?php if ($editRow): ?>
                                    <a href="model_manager.php" class="btn">Cancel</a>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                        <div class="span8">
                            <div class="admin-card">
                                <table class="table table-striped dynamicTable_user">
                                    <thead>
                                        <tr><th>Make</th><th>Model</th><th style="width:150px;">Actions</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rows as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['make_name']) ?></td>
                                            <td><?= htmlspecialchars($row['name']) ?></td>
                                            <td>
                                                <a href="?edit=<?= CommonBase::encrypt($row['Id']) ?>" class="btn btn-small">Edit</a>
                                                <form method="post" style="display:inline" onsubmit="return confirm('Delete this model?')">
                                                    <input type="hidden" name="del_id" value="<?= CommonBase::encrypt($row['Id']) ?>">
                                                    <button type="submit" name="lookup_delete_btn" class="btn btn-small btn-admin-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <? include_once './inc/comman_js.php'; ?>
    </body>
</html>
