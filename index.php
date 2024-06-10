<?php
require_once "src/nusoap.php";

$client = new nusoap_client("http://localhost/nu-soap/SoapServer.php?wsdl", "wsdl");
$error = $client->getError();
if ($error) {
    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}

$response = "";
if ($_POST) {
    $decade = $_POST['decade'];
    $params = array('decada' => $decade);
    $response = $client->call("get_peliculas", $params);

    if ($client->fault) {
        echo "<h2>Fault</h2><pre>";
        print_r($response);
        echo "</pre>";
    } else {
        $error = $client->getError();
        if ($error) {
            echo "<h2>Error</h2><pre>" . $error . "</pre>";
        } else {
            echo "<h2>Response</h2><pre>";
            print_r($response);
            echo "</pre>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOAP Client</title>
</head>
<body>
    <form action="index.php" method="post">
        Enter decade:
        <input type="text" name="decade" required>
        <br/>
        <input type="submit" value="Search">
    </form>
    <?php
    if (!empty($response)) {
        echo "<h3>Server Response:</h3>";
        echo "<p>$response</p>";
    }
    ?>
</body>
</html>
