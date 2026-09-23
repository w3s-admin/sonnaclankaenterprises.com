<?php
// Shared "this admin page is turned off for now" stop. Included by pages
// that still have working code behind them but shouldn't be reachable
// right now - `include` it right after the auth check and it halts the
// rest of that page's output.
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Not Available</title>
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/main.css" rel="stylesheet" type="text/css" />
</head>
<body style="padding:60px 20px;text-align:center;">
    <h2>This section is turned off for now</h2>
    <p>It isn't in use right now, but nothing was removed - it can be switched back on later.</p>
    <p><a href="dashboard.php" class="btn btn-admin-primary">Back to Dashboard</a></p>
</body>
</html>
<?php
exit;
