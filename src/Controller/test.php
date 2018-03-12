                  <?php

mysql_connect('hostname', 'username', 'password');
mysql_select_db('database-name');

$sql = "SELECT PcID FROM PC";
$result = mysql_query($sql);

echo "<select name='PcID'>";
while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['PcID'] . "'>" . $row['PcID'] . "</option>";
}
echo "</select>";

?>


<?php                   

echo "<select name='Country'>";
while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id'] . "'>" . $row['country_name'] . "</option>";
}
echo "</select>";

?>