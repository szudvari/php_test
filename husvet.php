<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        setlocale(LC_ALL,'hungarian');
        @$get_year = $_GET['ev'];
        if (isset($get_year)) {
            $year = $get_year;
        } else {
            $year = date("Y");
        }
        if ($year < 1901 || $year > 2099) {
            die("<b>Hibás évszám ($year).</b><br><br>A program csak 1901 és 2099 között tudja kiszámítani húsvét és pünkösd dátumát.");
        }
        $a = $year % 19;
        $b = $year % 4;
        $c = $year % 7;
        $d = ((19 * $a) + 24) % 30;
        $e = (2 * $b + 4 * $c + 6 * $d + 5) % 7;
        if ($e == 6 && $d == 29) {
            $h = 50;
        } else if ($e == 6 && $d == 28 && $a > 10) {
            $h = 49;
        } else {
            $h = 22 + $d + $e;
        }
        if ($h < 32) {
            $month = 3;
            $easter = $h;
        } else {
            $month = 4;
            $easter = $h - 31;
        }
        $easter_day = mktime(0, 0, 0, $month, $easter, $year);
        $easter_sun = strftime("%B %d.", $easter_day);
        $pentecost = strftime("%B %d.", strtotime("+49 days", $easter_day));
        echo "<b>$year. évben</b><br>";
        echo "<ul>";
        echo "<li><span style='width:180px; display:inline-block;'>Húsvét vasárnap dátuma: </span><b>". iconv("ISO-8859-2", "UTF-8", $easter_sun)."</b></li>";
        echo "<li><span style='width:180px; display:inline-block;'>Pünkösd vasárnap dátuma: </span><b>". iconv("ISO-8859-2", "UTF-8", $pentecost)."</b></li>";
        echo "</ul>";
        ?>
    </body>
</html>
