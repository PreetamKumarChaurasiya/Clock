<?php
$news_file = 'titles.txt';
$fp = @fopen($news_file, 'r');
if($fp) {
    $news_array = explode("\n", fread($fp, filesize($news_file)));
}

$WEATHER_API = '';
$response = file_get_contents($WEATHER_API);
$weather = json_decode($response, true);

// API returns Kelvin so need to convert
$ktoF = function($k) { return round(($k - 273.15) * 1.8 + 32, 0); };

?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Sean Thames">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="3600">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Kumar+One&display=swap" rel="stylesheet">
    <style type="text/css">
        * {
            background-color: #161616;
            color: #e9e9e9;
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: "Kumar One", cursive;
        }
        body {
            height: 480px;
            width: 800px;
        }
        div#container {
            height: 480px;
            width: 790px;
            overflow: hidden;
        }
        div#current {
            height: 215px;
        }
        div#current_weather {
            text-align: center;
            width: 260px;
            float: left;
        }
        div#temp {
            font-size: 100px;
            height: 150px;
            font-weight: bold;
        }
        div#description {
            font-size: 25px;
        }
        div#clock {
            font-size: 150px;
            font-weight: bold;
            width: 500px;
            float: right;
            text-align: center;
        }
        div#forecast {
            text-align: center;
        }
        div.daily_forecast {
            float: left;
            width: 258px;
            height: 150px;
            border: 1px solid white;
            border-radius: 5px;
            display: inline-block;
        }
        div.forecast_temp {
            font-size: 50px;
        }
        div.forecast_description {
            font-size: 20px;
        }
        div#news {
            text-align: center;
            vertiical-align: top;
            margin-top: 10px;
        }
        div.news_item {
            display: none;
            font-size: 25px;
            margin: 2px;
        }
    </style>
    <script>
        var current_article = 0;
        function setTime() {
            var time = new Date();
            var hours = ("0" + time.getHours()).slice(-2);
            var minutes = ("0" + time.getMinutes()).slice(-2);
            var seconds = ("0" + time.getSeconds()).slice(-2);
            
            var clock = document.getElementById("clock");
            clock.innerHTML = hours + ":" + minutes;
        }
        function newsCycle() {
            var newsItems = document.getElementsByClassName("news_item");
            var maxItems = newsItems.length - 1;
            newsItems[current_article].style.display = "none";
            if (current_article < maxItems) {
                current_article = current_article + 1;
            }
            else {
                current_article = 0;
            }
            newsItems[current_article].style.display = "block";
        }
    </script>
</head>
<body>
    <div id="container">
        <div id="current">
            <div id="current_weather">
                <div id="temp">
                    <?php
                        echo $ktoF($weather["current"]["temp"]);
                    ?>
                </div>
                <div id="description">
                    <?php
                        echo $weather["current"]["weather"][0]["main"];
                    ?>
                </div>
            </div>
            <div id="clock">
                00:00:00
            </div>
        </div>
        <div id="forecast">
            <div class="daily_forecast" id="day_one">
                <div class="forecast_temp">
                    <?php
                        echo $ktoF($weather["daily"][0]["temp"]["min"]);
                        echo "/";
                        echo $ktoF($weather["daily"][0]["temp"]["max"]);
                    ?>
                </div>
                <div class="forecast_description">
                    <?php
                        echo $weather["daily"][0]["weather"][0]["main"];
                    ?>
                </div>
                <div class="forecast_day">
                    <?php
                        echo date("l", $weather["daily"][0]["dt"]);
                    ?>
                </div>
            </div>
            <div class="daily_forecast" id="day_two">
                <div class="forecast_temp">
                    <?php
                        echo $ktoF($weather["daily"][1]["temp"]["min"]);
                        echo "/";
                        echo $ktoF($weather["daily"][1]["temp"]["max"]);
                    ?>
                </div>
                <div class="forecast_description">
                    <?php
                        echo $weather["daily"][1]["weather"][0]["main"];
                    ?>
                </div>
                <div class="forecast_day">
                    <?php
                        echo date("l", $weather["daily"][1]["dt"]);
                    ?>
                </div>
            </div>
            <div class="daily_forecast" id="day_three">
                <div class="forecast_temp">
                    <?php
                        echo $ktoF($weather["daily"][2]["temp"]["min"]);
                        echo "/";
                        echo $ktoF($weather["daily"][2]["temp"]["max"]);
                    ?>
                </div>
                <div class="forecast_description">
                    <?php
                        echo $weather["daily"][2]["weather"][0]["main"];
                    ?>
                </div>
                <div class="forecast_day">
                    <?php
                        echo date("l", $weather["daily"][2]["dt"]);
                    ?>
                </div>
            </div>
        </div>
        <div id="news">
            <?php
                foreach ($news_array as $title) {
                    echo '<div class="news_item">';
                    echo $title;
                    echo '</div>';
                }
            ?>
        </div>
    </div>
    <script>
        var time_interval = setInterval(setTime, 250);
        var news_cycle = setInterval(newsCycle, 30000);
        newsCycle();
    </script>
</body>
