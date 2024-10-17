<?php
    $conn = mysqli_connect("localhost","root","","czlowiek");
    if(isset($_POST['dodaj'])){
        if(isset($_POST['imie']) && $_POST['imie'] != "" && isset($_POST['nazwisko'])&& $_POST['nazwisko'] != ""  && isset($_POST['wiek']) && $_POST['wiek'] != "" ){
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];
            $wiek = $_POST['wiek'];
            $sql = "INSERT INTO `uczen` (`id`, `imie`, `nazwisko`, `wiek`) VALUES (NULL, \"$imie\", \"$nazwisko\", $wiek)";
            mysqli_query($conn, $sql);
            header("location:index.php");
        } else {
            echo "Wpisz wszystkie dane";
        }
    } elseif(isset($_POST['usun'])){
        $sql = "DELETE FROM uczen WHERE `uczen`.`id` = ".$_POST['usun'];
        mysqli_query($conn, $sql);
        header("location:index.php");
    } elseif(isset($_POST['zatwierdz'])){
        if(isset($_POST['imie']) && $_POST['imie'] != ""  && isset($_POST['nazwisko']) && $_POST['nazwisko'] != ""  && isset($_POST['wiek']) && $_POST['wiek'] != "" ){
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];
            $wiek = $_POST['wiek'];
            $sql = "UPDATE `uczen` SET `imie` = \"$imie\", `nazwisko` = \"$nazwisko\", `wiek` = $wiek WHERE `uczen`.`id` = ".$_POST['zatwierdz'];
            mysqli_query($conn, $sql);
            header("location:index.php");
        } else {
            echo "Wpisz wszystkie dane";
        }
    }
    $sql = "SELECT * FROM uczen WHERE 1";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie</title>
</head>
<body>
    <form method="post">
        <table>
            <?php
                if(!isset($_POST['edytuj'])){
                    echo "<tr>";
                    echo "<td><input type=\"text\" placeholder=\"imie\" name=\"imie\" id=\"imie\" oninput=\"waliduj()\"></td>";
                    echo "<td><input type=\"text\" placeholder=\"nazwisko\" name=\"nazwisko\" id=\"nazwisko\" oninput=\"waliduj()\"></td>";
                    echo "<td><input type=\"number\" placeholder=\"wiek\" name=\"wiek\" id=\"wiek\" oninput=\"waliduj()\"></td>";
                    echo "<td><button name=\"dodaj\" id=\"dodaj\" disabled onclick=waliduj()>dodaj</button></td>";
                    echo "<button name=\"edytuj\" id=\"edytuj\" value=\"0\" disabled hidden>edytuj</button>";
                    echo "</tr>";
                }
            ?>
            <tr>
                <th>id</th>
                <th>imie</th>
                <th>nazwisko</th>
                <th>wiek</th>
                <th>opcje</th>
            </tr>
            <?php
                while($row = mysqli_fetch_array($result)){
                    $id = $row['id'];
                    $imie = $row['imie'];
                    $nazwisko = $row['nazwisko'];
                    $wiek = $row['wiek'];
                    echo "<tr>";
                    if(isset($_POST['edytuj']) && $id == $_POST['edytuj']){
                        echo "<td>$id</td>";
                        echo "<td><input type=\"text\" placeholder=\"imie\" name=\"imie\" id=\"imie\" value=\"$imie\" oninput=\"waliduj()\"></td>";
                        echo "<td><input type=\"text\" placeholder=\"nazwisko\" name=\"nazwisko\" id=\"nazwisko\" value=\"$nazwisko\" oninput=\"waliduj()\"></td>";
                        echo "<td><input type=\"number\" placeholder=\"wiek\" name=\"wiek\" id=\"wiek\" value=\"$wiek\" oninput=\"waliduj()\"></td>";
                        echo "<td><button name=\"anuluj\" value=\"$id\">anuluj</button> <button name=\"zatwierdz\" id=\"zatwierdz\" value=\"$id\" onclick=waliduj()>zatwierdz</button> <button name=\"dodaj\" id=\"dodaj\" disabled hidden>dodaj</button></td>";
                        echo "</tr>";
                    } else {
                        echo "<td>$id</td>";
                        echo "<td>$imie</td>";
                        echo "<td>$nazwisko</td>";
                        echo "<td>$wiek</td>";
                        echo "<td><button name=\"usun\" value=\"$id\">usun</button> <button name=\"edytuj\" id=\"edytuj\" value=\"$id\">edytuj</button></td>";
                        echo "</tr>";
                    }
                }



            ?>
        </table>
    </form>
    <script>
        function waliduj(){
            let disable = false;
            let dodaj = document.getElementById("dodaj");
            let zatwierdz = document.getElementById("zatwierdz");

            let imie = document.getElementById("imie");
            let nazwisko = document.getElementById("nazwisko");
            let wiek = document.getElementById("wiek");

            if(imie.value == ""){
                disable = true;
            }
            if(nazwisko.value == ""){
                disable = true;
            }
            if((wiek.value < 0 || wiek.value > 120) && wiek.value == ""){
                disable = true;
            }
            dodaj.disabled = disable;
            zatwierdz.disabled = disable;
        }
    </script>
</body>
</html>