<?php

$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');

// This query will be changed for future implementations.
$sql_query = 'SELECT * FROM plants';
$records = exec_sql_query($db, $sql_query)->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Plant Catalog</title>
  <link rel="stylesheet" href="public/styles/site.css">
</head>

<body>

  <h1>Playful Plants Project</h1>

  <div class="row">
    <div class="login">
      <a href="/login">
        <button>Log In</button>
      </a>
    </div>
    <div class="sort-filter">
      Sort:
      <select name="sort">
        <option value="Name Ascending">Name Ascending</option>
        <option value="Name Descending">Name Descending</option>
      </select>
    </div>
    <div class="sort-filter">
      <button>Filter</button>
    </div>
  </div>

  <div class="catalog-gallery">
    <?php
    foreach ($records as $record) {
      $plant_ID = $record['plant_ID'];
      $file_name = "./public/photos/" . $plant_ID . ".jpg";
      if (!file_exists($file_name)) {
        $file_name = "/public/photos/image_placeholder.jpg";
      }
    ?>
      <div class="gallery">
        <a href="/details?<?php echo http_build_query(array('id' => $plant_ID)); ?>"><img src=<?php echo htmlspecialchars($file_name); ?> alt="Plant" width="200" height="200"></a>
        <div class="tile-header">
          <div class="name"><?php echo htmlspecialchars($record['plant_name_coll']); ?></div>
        </div>
      </div>
    <?php } ?>

  </div>



</body>

</html>
