<?php

/**
 * Shared data-access helper for the simple vehicle-attribute lookup tables
 * (make, model, colour, body_type, transmission, fuel, engine_capacity).
 * $table and $statusCol are always passed as fixed string literals by the
 * calling manager page, never from request input, so interpolating them
 * into the SQL here is safe.
 */
class Lookup {

    public static function getAll($table, $statusCol = 'status', $extraSelect = '', $extraWhere = '', $orderBy = 'name ASC') {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $select = "Id, name" . ($extraSelect ? ", $extraSelect" : "");
        $where = "`$statusCol` = 1" . ($extraWhere ? " AND $extraWhere" : "");
        $stmt = $dbh->prepare("SELECT $select FROM `$table` WHERE $where ORDER BY $orderBy");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($table, $id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * FROM `$table` WHERE Id = ?");
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function add($table, $fields) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $cols = array_keys($fields);
        $colList = '`' . implode('`, `', $cols) . '`';
        $placeholders = implode(',', array_fill(0, count($cols), '?'));
        $stmt = $dbh->prepare("INSERT INTO `$table` ($colList) VALUES ($placeholders)");
        return $stmt->execute(array_values($fields));
    }

    public static function update($table, $id, $fields) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $setParts = array();
        foreach (array_keys($fields) as $col) {
            $setParts[] = "`$col` = ?";
        }
        $values = array_values($fields);
        $values[] = $id;
        $stmt = $dbh->prepare("UPDATE `$table` SET " . implode(', ', $setParts) . " WHERE Id = ?");
        return $stmt->execute($values);
    }

    public static function softDelete($table, $id, $statusCol = 'status') {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("UPDATE `$table` SET `$statusCol` = 0 WHERE Id = ?");
        return $stmt->execute(array($id));
    }

    public static function nameExists($table, $name, $excludeId = null) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $q = "SELECT Id FROM `$table` WHERE name = ?";
        $params = array($name);
        if ($excludeId !== null) {
            $q .= " AND Id != ?";
            $params[] = $excludeId;
        }
        $stmt = $dbh->prepare($q);
        $stmt->execute($params);
        return (bool) $stmt->fetch();
    }
}
