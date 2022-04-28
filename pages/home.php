<?php

// --- Define Variables ---

$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');
$uri = $_SERVER['REQUEST_URI'];
$params = $_GET;

// --- Handle Sorting ---

$sticky_sort_asc = '';
$sticky_sort_desc = '';
$sticky_sort_default = '';

$sql_order_part = '';
$order = $_GET['order'] ?? NULL;
if ($order == 'asc') {
  $sql_order_part = ' ORDER BY plant_name_coll ASC';
  $sticky_sort_asc = 'selected';
} else if ($order == 'desc') {
  $sql_order_part = ' ORDER BY plant_name_coll DESC';
  $sticky_sort_desc = 'selected';
} else {
  $sticky_sort_default = 'selected';
}

// --- Handle Filtering ---

$sql_where_part = '';
$filter = $_GET['filter'] ?? NULL;
if ($filter) {
  $sql_where_part = ' WHERE tags.tag_name = "' . $filter . '"';
}

$sticky_filter_default = ($filter ? '' : 'selected');
$sticky_filter_shrub = (($filter != "Shrub") ? '' : 'selected');
$sticky_filter_grass = (($filter != "Grass") ? '' : 'selected');
$sticky_filter_vine = (($filter != "Vine") ? '' : 'selected');
$sticky_filter_tree = (($filter != "Tree") ? '' : 'selected');
$sticky_filter_flower = (($filter != "Flower") ? '' : 'selected');
$sticky_filter_groundcover = (($filter != "Groundcover") ? '' : 'selected');
$sticky_filter_other = (($filter != "Other") ? '' : 'selected');

// --- Get Records From Database ---

$sql_query = 'SELECT * FROM plants INNER JOIN plant_tags on plants.id = plant_tags.plant_id INNER JOIN tags on tags.tag_id = plant_tags.tag_id' . $sql_where_part . $sql_order_part;
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
      <a href="/admin">
        <button>Log In</button>
      </a>
    </div>

    <div class="sort-filter">
      Sort:
      <select name="sort" onchange="location = this.value;">
        <?php $new_params = $params;
        $new_params['order'] = 'asc';
        $new_uri = '/?' . http_build_query($new_params); ?>
        <option value=<?php echo $new_uri; ?> <?php echo $sticky_sort_default ?>></option>

        <?php
        $new_params = $params;
        $new_params['order'] = 'asc';
        $new_uri = '/?' . http_build_query($new_params); ?>
        <option value=<?php echo $new_uri; ?> <?php echo $sticky_sort_asc; ?>>Name Ascending</option>

        <?php
        $new_params = $params;
        $new_params['order'] = 'desc';
        $new_uri = '/?' . http_build_query($new_params); ?>
        <option value=<?php echo $new_uri; ?> <?php echo $sticky_sort_desc; ?>>Name Descending</option>
      </select>
    </div>

    <div class="sort-filter">
      Filter By Tag:
      <select name="filter" onchange="location = this.value;">
        <?php $params['filter'] = '';
        $new_uri = '/?' . http_build_query($params); ?>
        <option value=<?php echo $new_uri; ?> <?php echo $sticky_filter_default ?>></option>

        <?php $params['filter'] = 'Shrub';
        $new_uri = '/?' . http_build_query($params); ?>
        <option value=<?php echo $new_uri; ?> <?php echo $sticky_filter_shrub; ?>>Shrub</option>

        <?php $params['filter'] = 'Grass';
        $new_uri = '/?' . http_build_query($params); ?>
        <option value=<?php echo $new_uri; ?> <?php echo $sticky_filter_grass; ?>>Grass</option>

        <?php $params['filter'] = 'Vine';
        $new_uri = '/?' . http_build_query($params); ?>
        <option value=<?php echo $new_uri; ?> <?php echo $sticky_filter_vine; ?>>Vine</option>

        <?php $params['filter'] = 'Tree';
        $new_uri = '/?' . http_build_query($params); ?>
        <option value=<?php echo $new_uri; ?> <?php echo $sticky_filter_tree; ?>>Tree</option>

        <?php $params['filter'] = 'Flower';
        $new_uri = '/?' . http_build_query($params); ?>
        <option value=<?php echo $new_uri; ?> <?php echo $sticky_filter_flower; ?>>Flower</option>

        <?php $params['filter'] = 'Groundcover';
        $new_uri = '/?' . http_build_query($params); ?>
        <option value=<?php echo $new_uri; ?> <?php echo $sticky_filter_groundcover; ?>>Groundcover</option>

        <?php $params['filter'] = 'Other';
        $new_uri = '/?' . http_build_query($params); ?>
        <option value=<?php echo $new_uri; ?> <?php echo $sticky_filter_other; ?>>Other</option>
      </select>
    </div>
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
