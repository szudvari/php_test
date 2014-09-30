<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        //paraméter beolvasása
        @$get_year = $_GET['ev'];
        //van-e paraméter
        if (isset($get_year)) {
            $year = $get_year; //ha igen, azt az évet használjuk
        } else {
            $year = date("Y"); //ha nem, az aktuális évszámot használjuk
        }
        //tartományon kívüli évszámok kizárása
        if ($year < 1901 || $year > 2099) {
            die("<b>Hibás évszám ($year).</b><br><br>A program csak 1901 és 2099 között tudja kiszámítani húsvét és pünkösd dátumát.");
        }
        //hónap tömb
        $months = array(3=>"március", 4=>"április", 5=>"május", 6=>"június");
        // számítás
        $a = $year % 19;
        $b = $year % 4;
        $c = $year % 7;
        $d = ((19 * $a) + 24) % 30;
        $e = (2 * $b + 4 * $c + 6 * $d + 5) % 7;
        //nap kiszámítása (kivételek kezelésével)
        if ($e == 6 && $d == 29) {
            $h = 50;
        } else if ($e == 6 && $d == 28 && $a > 10) {
            $h = 49;
        } else {
            $h = 22 + $d + $e;
        }
        // hónap és nap meghatározása
        if ($h < 32) {
            $month = 03;
            $easter_month = $months[3];
            $easter_day = $h;
        } else {
            $month = 04;
            $easter_month = $months[4];
            $easter_day = $h - 31;
        }
        //dátum lefordítása 
        $dateSrc = $year."-".$month."-".$easter_day." 00:00"; 
        $pentcost_date = new DateTime($dateSrc);
        //pünkösd kiszámítása
        date_add($pentcost_date,date_interval_create_from_date_string("49 days"));
        //pünkösd hónapjának lefordítása szöveggé
        switch (date_format($pentcost_date,"m")) {
            case '04': 
                $pencost_month = $months[4];
                break;
            case '05':
                $pencost_month = $months[5];
                break;
           case '06':
                $pencost_month = $months[6];
                break;
        }
        //pünkösd napjának lefordítása szöveggé
        $pencost_day=date_format($pentcost_date,'j');
        //adatok kírása a képernyőre
        echo "<b>$year. évben</b><br>";
        echo "<ul>";
        echo "<li><span style='width:180px; display:inline-block;'>Húsvét vasárnap dátuma: </span><b>$easter_month $easter_day.</b></li>";
        echo "<li><span style='width:180px; display:inline-block;'>Pünkösd vasárnap dátuma: </span><b>$pencost_month $pencost_day.</b></li>";
        echo "</ul>";
        ?>
    </body>
</html>
