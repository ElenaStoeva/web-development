<?php

$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');

$sql_order_part = '';
$order = $_GET['order'] ?? NULL;
if ($order == 'asc') {
  $sql_order_part = ' ORDER BY plant_name_coll ASC';
} else if ($order == 'desc') {
  $sql_order_part = ' ORDER BY plant_name_coll DESC';
}

// This query will be changed for future implementations.
$sql_query = 'SELECT * FROM plants' . $sql_order_part;
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
      <select name="sort" onchange="location = this.value;">
        <option value="/"></option>
        <option value="/?order=asc">Name Ascending</option>
        <option value="/?order=desc">Name Descending</option>
      </select>
    </div>
    <div class="filter-dropdown sort-filter">
      <button onclick="clickFilter()" class="dropbtn">Filter</button>
      <div id="filterDropdown" class="filter-dropdown-content">
        <ul>
          <li>
            <input type="checkbox" id="shrub_tag" name="shrub_tag" />
            <label for="shrub_tag">Shrub</label>
          </li>
          <li>
            <input type="checkbox" id="grass_tag" name="grass_tag" />
            <label for="grass_tag">Grass</label>
          </li>
          <li>
            <input type="checkbox" id="vine_tag" name="vine_tag" />
            <label for="vine_tag">Vine</label>
          </li>
          <li>
            <input type="checkbox" id="tree_tag" name="tree_tag" />
            <label for="tree_tag">Tree</label>
          </li>
          <li>
            <input type="checkbox" id="flower_tag" name="flower_tag" />
            <label for="flower_tag">Flower</label>
          </li>
          <li>
            <input type="checkbox" id="groundcover_tag" name="groundcover_tag" />
            <label for="groundcover_tag">Groundcover</label>
          </li>
          <li>
            <input type="checkbox" id="other_tag" name="other_tag" />
            <label for="other_tag">Other</label>
          </li>
        </ul>
      </div>
    </div>


    <script>
      function clickFilter() {
        document.getElementById("filterDropdown").classList.toggle("show");
      }
    </script>
  </div>

  <div class="catalog-gallery">
    <?php
    foreach ($records as $record) {
      $plant_ID = $record['plant_ID'];
      $file_name = "./public/photos/" . $plant_ID . ".jpg";
      if (!file_exists($file_name)) {
        // Image Source: (original work) Elena Stoeva
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
