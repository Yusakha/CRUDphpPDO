<?php
try {
  $db = new PDO('mysql:host=localhost;dbname=uts192410102084','192410102084','lastdance');
} catch (\Exception $e) {
  echo $e->getMessage;
}