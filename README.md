# Clock

My first attempt at making a clock with weather and news feed


## Hardware
* Raspberry Pi 4
* 7" Raspberry Pi Touchscreen
* Pi and Touchscreen enclosure

## Installation/Configuration
1. Install php and python3 to the Pi
2. Create a new user that will autologin and launch your preferred browser in full screen
3. Give whatever user is running the cronjob permission to write to the `/var/www/html` directory
4. Add `news.py` to a cron job running at whatever frequency you would like. I chose every six hours.
5. Copy `index.php` to `/var/www/html/index.php` everything is included in the one file for simplicity
6. Insert your weather api query string in to `index.php`
    - I used api.openweathermap.org single api that gives everything and so the php is designed around the response it gives
7. Reboot the Pi and if everything is working properly you should see the current time weather and a rotating news title.

## Notes
The page auto refreshes once an hour to grab the latest weather data. You can change this as desired by modifying `<meta http-equiv="refresh" content="3600">` on line 21 in `index.php`

