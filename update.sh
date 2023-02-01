git pull &&
gulp
rtlcss public/css/index.css public/css/index-rtl.css
rsync -zarPhI ./public/ ../public_html #--ignore-existing or --delete
#rsync -zarPhI ~/index.php ../public_html/index.php
#\cp -r ./public/* ../public_html/
#\cp ~/index.php ../public_html/
