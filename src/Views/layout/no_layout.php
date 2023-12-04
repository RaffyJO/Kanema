<?php
require_once __DIR__ . '/../templates/source.php';
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title><?php if (isset($TPL->title)) {
            echo $TPL->title;
          } ?></title>
  <?php if (isset($TPL->headcontent)) {
    include $TPL->headcontent;
  } ?>
</head>

<body>
  <?php if (isset($TPL->bodycontent)) {
    include $TPL->bodycontent;
  } ?>
  <?php include __DIR__ . "/../templates/footer.php" ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>

</html>