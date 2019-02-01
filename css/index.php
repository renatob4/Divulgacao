<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trust</title>
    <!--Bootstrap 4.0-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css"
    integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous"/>
    <!-- Css -->
    <link rel="stylesheet" href="../css/main.css"/>
</head>
<body>
    <div class="container contentor-global pt-1">
        <div class="row p-3">
            <div class="col-sm-6 text-center">
                <img class="img-fluid ml-0 p-0" src="../images/logo.png">
            </div>
            <div class="col-sm-6  text-center mt-2">
            <h3>Olá, está perdido visitante? <label id="grey" style="font-weight: normal"><?php echo "$_SERVER[REMOTE_ADDR]" ?></label></h3>
            <h5>Clique <a href="<?php echo "http://$_SERVER[HTTP_HOST]"?>">aqui</a> para voltar ao inicio.</h5>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
</body>
</html>