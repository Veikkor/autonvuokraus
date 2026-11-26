<?php
require_once('db.php');
$virhe = '';  
$viesti = '';
$etunimi = '';  
$sukunimi = '';
$katuosoite = '';
$postitoimipaikka = '';
$puhelin = '';
$saika = '';
$email = '';
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $etunimi = trim($_POST['etunimi']);
    $sukunimi = trim($_POST['sukunimi']);
    $katuosoite = trim($_POST['katuosoite']);
    $postitoimipaikka = trim($_POST['postitoimipaikka']);
    $puhelin = trim($_POST['puhelin']);
    $saika = trim($_POST['saika']);
    $email = trim($_POST['email']);
 
    if ($etunimi == '' || $sukunimi == '' || $katuosoite == '' || $postitoimipaikka == '' || $puhelin == '' || $saika == '' || $email == '') {
        $virhe = "Täytä kaikki kentät.";
    }
 
    if ($virhe == '') {
        $sql = "INSERT INTO asiakas (etunimi, sukunimi, katuosoite, postitoimipaikka, puhelin, saika, email) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($yhteys, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $etunimi, $sukunimi, $katuosoite, $postitoimipaikka, $puhelin, $saika, $email);
        if (mysqli_stmt_execute($stmt)) {
            $viesti = "Asiakas lisättiin.";
            $etunimi = '';
            $sukunimi = '';
            $katuosoite = '';
            $postitoimipaikka = '';
            $puhelin = '';
            $saika = '';
            $email = '';
        } else {
            $virhe = "Tallennus epäonnistui.";
        }
    }
}
?>
<!doctype html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää asiakas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>Lisää asiakas</h1>

<?php if ($virhe != '') { ?>
    <p class="viesti virhe"><?= htmlspecialchars($virhe) ?></p>
<?php } ?>
<?php if ($viesti != '') { ?>
    <p class="viesti"><?= htmlspecialchars($viesti) ?></p>
<?php } ?>
<form method="post">
    <p>
        <label>Etunimi:</label>
        <input type="text" name="etunimi" value="<?= htmlspecialchars($etunimi) ?>">
    </p>
    <p>
        <label>Sukunimi:</label>
        <input type="text" name="sukunimi" value="<?= htmlspecialchars($sukunimi) ?>">
    </p>
    <p>
        <label>Katuosoite:</label>
        <input type="text" name="katuosoite" value="<?= htmlspecialchars($katuosoite) ?>">
    </p>
    <p>
        <label>Postitoimipaikka:</label>
        <input type="text" name="postitoimipaikka" value="<?= htmlspecialchars($postitoimipaikka) ?>">
    </p>
    <p>
        <label>Puhelinnumero:</label>
        <input type="text" name="puhelin" value="<?= htmlspecialchars($puhelin) ?>">
    </p>
    <p>
        <label>Syntymäaika:</label>
        <input type="date" name="saika" value="<?= htmlspecialchars($saika) ?>">
    </p>
    <p>
        <label>Sähköposti:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($email) ?>">
    </p>
    <input type="submit" value="Lisää asiakas">
</form>
</body>
</html>
