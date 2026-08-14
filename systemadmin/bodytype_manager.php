<?
require_once '../cpad/clsCommonBase.php';
require_once '../cpad/clsLookup.php';
CommonBase::IsAdminUser();

$table = 'body_type';
$statusCol = 'status';
$errmsg = '';
$msg = '';

if (isset($_POST['lookup_add_btn'])) {
    $name = trim($_POST['name'] ?? '');
    $group = ($_POST['vehicle_group'] ?? 'car') === 'motorcycle' ? 'motorcycle' : 'car';
    if ($name === '') {
        $errmsg = 'Name is required.';
    } elseif (Lookup::nameExists($table, $name)) {
        $errmsg = 'That body type already exists.';
    } else {
        Lookup::add($table, array('name' => $name, $statusCol => 1, 'vehicle_group' => $group));
        $msg = 'Body type added.';
    }
}

if (isset($_POST['lookup_update_btn'])) {
    $id = CommonBase::decrypt($_POST['edit_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $group = ($_POST['vehicle_group'] ?? 'car') === 'motorcycle' ? 'motorcycle' : 'car';
    if (is_numeric($id) && $name !== '') {
        if (Lookup::nameExists($table, $name, $id)) {
            $errmsg = 'Another body type already has that name.';
        } else {
            Lookup::update($table, $id, array('name' => $name, 'vehicle_group' => $group));
            $msg = 'Body type updated.';
        }
    }
}

if (isset($_POST['lookup_delete_btn'])) {
    $id = CommonBase::decrypt($_POST['del_id'] ?? '');
    if (is_numeric($id)) {
        Lookup::softDelete($table, $id, $statusCol);
        CommonBase::SendRedirect('bodytype_manager.php');
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

$rows = Lookup::getAll($table, $statusCol, 'vehicle_group');
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
                        <h3>Body Type Manager</h3>
                        <ul class="breadcrumb">
                            <li>You are here:</li>
                            <li>Vehicle Attributes</li>
                            <li class="active">Body Type Manager</li>
                        </ul>
                    </div>

                    <div class="row-fluid">
                        <div class="span4">
                            <div class="admin-card">
                                <h4 style="margin-top:0;"><?= $editRow ? 'Edit Body Type' : 'Add New Body Type' ?></h4>
                                <?php if ($errmsg): ?><div class="alert alert-error"><?= htmlspecialchars($errmsg) ?></div><?php endif; ?>
                                <?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
                                <form method="post">
                                    <?php if ($editRow): ?>
                                    <input type="hidden" name="edit_id" value="<?= CommonBase::encrypt($editRow['Id']) ?>">
                                    <?php endif; ?>
                                    <div class="control-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="span12" value="<?= htmlspecialchars($editRow['name'] ?? '') ?>" required>
                                    </div>
                                    <div class="control-group">
                                        <label class="form-label">Vehicle Group</label>
                                        <select name="vehicle_group" class="span12">
                                            <option value="car" <?= (($editRow['vehicle_group'] ?? 'car') === 'car') ? 'selected' : '' ?>>Car</option>
                                            <option value="motorcycle" <?= (($editRow['vehicle_group'] ?? '') === 'motorcycle') ? 'selected' : '' ?>>Motor Bicycle</option>
                                        </select>
                                    </div>
                                    <br>
                                    <button type="submit" name="<?= $editRow ? 'lookup_update_btn' : 'lookup_add_btn' ?>" class="btn btn-admin-primary">
                                        <?= $editRow ? 'Update' : 'Add Body Type' ?>
                                    </button>
                                    <?php if ($editRow): ?>
                                    <a href="bodytype_manager.php" class="btn">Cancel</a>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                        <div class="span8">
                            <div class="admin-card">
                                <table class="table table-striped dynamicTable_user">
                                    <thead>
                                        <tr><th>Name</th><th>Vehicle Group</th><th style="width:150px;">Actions</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rows as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['name']) ?></td>
                                            <td>
                                                <?php if ($row['vehicle_group'] === 'motorcycle'): ?>
                                                    <span class="status-badge inactive">Motor Bicycle</span>
                                                <?php else: ?>
                                                    <span class="status-badge active">Car</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="?edit=<?= CommonBase::encrypt($row['Id']) ?>" class="btn btn-small">Edit</a>
                                                <form method="post" style="display:inline" onsubmit="return confirm('Delete this body type?')">
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
