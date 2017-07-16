<?php
echo "<table style='border:1px solid black;border-collapse:collapse;'>";
$row = 1;
if (($handle = fopen("csv_format.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<tr style='border:1px solid black;'>";
		$row++;
        for ($c=0; $c < $num; $c++) {
            echo "<td style='border:1px solid black;'>" . $data[$c] . "</td>";
        }
		echo "</tr>";
    }
    fclose($handle);
}
echo "</table>";
?>