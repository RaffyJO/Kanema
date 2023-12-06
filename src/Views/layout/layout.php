<?php
require_once(__DIR__ . '/../templates/source.php');
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
  <?php include __DIR__ . "/../templates/header.php" ?>
  <div class="p-4 sm:ml-64">
    <div class="mt-14">
      <div class="container mx-auto px-5 bg-white">
        <?php if (isset($TPL->bodycontent)) {
          include $TPL->bodycontent;
        } ?></div>
    </div>
  </div>
  <?php include __DIR__ . "/../templates/footer.php" ?>
  <script src="https://cdn.jsdelivr.net/npm/preline@2.0.2/dist/preline.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>

</html>