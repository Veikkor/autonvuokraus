<?php
require_once('db.php');
$virhe = '';  $viesti = '';
$asiakasid = 0;  $autoid = 0;  $aloituspvm = '';  $lopetuspvm = '';
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asiakasid = (int)$_POST['asiakasid'];      // valikko lähettää id-numeron
    $autoid = (int)$_POST['autoid'];
    $aloituspvm = trim($_POST['aloituspvm']);
    $lopetuspvm = trim($_POST['lopetuspvm']);
 
    if ($asiakasid == 0 || $autoid == 0 || $aloituspvm == '' || $lopetuspvm == '') {
        $virhe = "Valitse asiakas ja auto sekä anna molemmat päivämäärät.";
    }
 
    if ($virhe == '') {
        // 1) uusi rivi sopimus-tauluun
        $sql = "INSERT INTO sopimus (asiakasid, autoid, aloituspvm, lopetuspvm) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($yhteys, $sql);
        mysqli_stmt_bind_param($stmt, "iiss", $asiakasid, $autoid, $aloituspvm, $lopetuspvm);
        if (mysqli_stmt_execute($stmt)) {
            $sql = "UPDATE auto SET onkovapaa = 0 WHERE id = ?";
            $stmt = mysqli_prepare($yhteys, $sql);
            mysqli_stmt_bind_param($stmt, "i", $autoid);
            mysqli_stmt_execute($stmt);
            $viesti = "Vuokraus lisättiin.";
            $asiakasid = 0;
            $autoid = 0;
            $aloituspvm = "";
            $lopetuspvm = "";
        }
        else {
            $virhe = "Vuokrauksen tallennus epäonnistui.";
        }
    }
}
// Valikoiden tiedot (while-silmukalla <option>-rivit HTML-osassa)
$asiakkaat = mysqli_query($yhteys, "SELECT id, etunimi, sukunimi FROM asiakas");
$autot = mysqli_query($yhteys, "SELECT id, valmistaja, malli FROM auto WHERE onkovapaa = 1");
?>
<!doctype html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää vuokraus</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>Lisää vuokraus</h1>
<?php if ($virhe != '') { ?><p class="viesti virhe"><?= htmlspecialchars($virhe) ?></p><?php } ?>
<?php if ($viesti != '') { ?><p class="viesti"><?= htmlspecialchars($viesti) ?></p><?php } ?>
<form method="post">
    <p>
        <label>Asiakas:</label>
        <select name="asiakasid">
            <option value="0">-- Valitse --</option>
            <?php while ($rivi = mysqli_fetch_assoc($asiakkaat)) { ?>
                <option value="<?= (int)$rivi['id'] ?>">
                    <?= htmlspecialchars($rivi['etunimi'] . " " . $rivi['sukunimi']) ?>
                </option>
            <?php } ?>
        </select>
    </p>
    <p>
        <label>Auto:</label>
        <select name="autoid">
            <option value="0">-- Valitse --</option>
            <?php while ($rivi = mysqli_fetch_assoc($autot)) { ?>
                <option value="<?= (int)$rivi['id'] ?>">
                    <?= htmlspecialchars($rivi['valmistaja'] . " " . $rivi['malli']) ?>
                </option>
            <?php } ?>
        </select>
    </p>
    <p>
        <label>Vuokrauksen alkamispäivä:</label>
        <input type="date" name="aloituspvm" value="<?= htmlspecialchars($aloituspvm) ?>">
    </p>
    <p>
        <label>Vuokrauksen päättymispäivä:</label>
        <input type="date" name="lopetuspvm" value="<?= htmlspecialchars($lopetuspvm) ?>">
    </p>
    <input type="submit" value="Lisää vuokraus">
</form>
</body>
</html>
