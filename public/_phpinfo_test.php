<?php
echo "upload_max_filesize=" . ini_get('upload_max_filesize') . "\n";
echo "post_max_size=" . ini_get('post_max_size') . "\n";
echo "php_ini_loaded=" . php_ini_loaded_file() . "\n";
echo "sapi=" . php_sapi_name() . "\n";
