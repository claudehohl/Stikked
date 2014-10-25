<?php
header('Content-type: text/plain');
//header('Content-disposition: attachment');
header('Content-disposition: attachment;filename=' . $title . '.' . $lang_code);
echo htmlspecialchars_decode($raw);


