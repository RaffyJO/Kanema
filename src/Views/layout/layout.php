<?php
require_once(__DIR__ . '/../templates/source.php');
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
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

  <!--  -->
  <style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
  </style>
</head>

<body id="body">
  <div class="absolute top-14 right-0 w-full h-fit hidden flex justify-end z-[100]" id="box-alert">
  </div>
  <?php include __DIR__ . "/../templates/header.php" ?>
  <div class="p-4 sm:ml-64">
    <div class="mt-14">
      <div class="container mx-auto bg-white">
        <?php if (isset($TPL->bodycontent)) {
          include $TPL->bodycontent;
        } ?></div>
    </div>
  </div>
  <?php include __DIR__ . "/../templates/footer.php" ?>
  <script src="https://cdn.jsdelivr.net/npm/preline@2.0.2/dist/preline.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

  <script>
    function removeComments(element) {
      for (let i = element.childNodes.length - 1; i >= 0; i--) {
        const node = element.childNodes[i];

        if (node.nodeType === Node.COMMENT_NODE) {
          element.removeChild(node);
        } else if (node.nodeType === Node.ELEMENT_NODE) {
          removeComments(node);
        }
      }
    }

    const parentElement = document.getElementById('body');
    removeComments(parentElement);
  </script>
</body>

</html>