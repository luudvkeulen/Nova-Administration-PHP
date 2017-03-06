<?php require('classes/PlayerDAO.php'); ?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.css"/>
    <?php include('partials/head.php'); ?>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js"></script>
</head>
<body class="header-body">
<?php include('partials/header.php'); ?>
<div class="container jumbocontainer">
    <div class="jumbotron">
        <h1>Players</h1>
        <table id="players" class="table table-striped" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Steam Id</th>
                <th>Nickname</th>
                <th>Bans</th>
                <th>Comments</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $database = new Database();
                $database->query("SELECT * FROM players");
                $rows = $database->resultSet();
            ?>
            <tr>
                <td>123345</td>
                <td>Test</td>
                <td>5</td>
                <td>3</td>
            </tr>
            <tr>
                <td>1233231345</td>
                <td>Test2</td>
                <td>0</td>
                <td>3</td>
            </tr>
            </tbody>
        </table>
        <form method="post">
            <div class="row form-row">
                <div class="col-md-5 form-col">
                    <input id="steamid" class="form-control" type="text" placeholder="steam id" maxlength="17" pattern="^[0-9]{17}$" />
                </div>
                <div class="col-md-5 form-col">
                    <input id="nickname" class="form-control" type="text" placeholder="nickname"/>
                </div>
                <div class="col-md-2 form-col">
                    <input class="btn btn-success addplayerbutton" type="submit" value="Add"/>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>