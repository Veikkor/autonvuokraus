<?php
require_once('db.php');
$sql = "SELECT * FROM auto";
$tulos = mysqli_query($yhteys, $sql);
?>
<!doctype html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Autot</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Autot</h1>
    <table>
    <tr>
        <th>Kuva</th>
        <th>Rekisterinumero</th>
        <th>Valmistaja</th>
        <th>Malli</th>
        <th>Onko Automaatti</th>
        <th>Moottori</th>
        <th>Istumapaikat</th>
        <th>Hinta</th>
        <th>Vapaana</th>
    </tr>
<?php while ($rivi = mysqli_fetch_assoc($tulos)) { ?>
    <tr>
        <td><img src="../images/<?= htmlspecialchars($rivi['malli']) ?>.jpg" width="100"></td>
        <td><?= htmlspecialchars($rivi['rekno']) ?></td>
        <td><?= htmlspecialchars($rivi['valmistaja']) ?></td>
        <td><?= htmlspecialchars($rivi['malli']) ?></td>
        <td><?= htmlspecialchars($rivi['onkoautomaatti'] ? "Kyllä" : "Ei") ?></td>
        <td><?= htmlspecialchars($rivi['moottori']) ?></td>
        <td><?= htmlspecialchars($rivi['istumapaikat']) ?></td>
        <td><?= htmlspecialchars($rivi['hinta']) ?></td>
        <td><?= htmlspecialchars($rivi['onkovapaa'] ? "Kyllä" : "Ei") ?></td>
    </tr>
<?php } ?>
</table>
</body>
</html>
<p><a href="../index.php">Palaa etusivulle</a></p>