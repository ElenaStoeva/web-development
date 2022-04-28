<?php
$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');
$plant_ID = $_GET['id'];
$sql_query = "SELECT * FROM plants LEFT OUTER JOIN plant_tags on plants.id = plant_tags.plant_id LEFT OUTER JOIN tags on tags.tag_id = plant_tags.tag_id WHERE plants.plant_ID ='" . $plant_ID . "'";
$records = exec_sql_query($db, $sql_query)->fetchAll();
$record = $records[0];

// Get all tags of this plant
$tags = array();
foreach ($records as $record) {
  array_push($tags, $record['tag_name']);
}

$tag_names = "None";
if (count($tags) > 0) {
  $tag_names = implode(", ", $tags);
}

$file_name = "./public/photos/" . $plant_ID . ".jpg";
if (!file_exists($file_name)) {
  // Image Source: (original work) Elena Stoeva
  $file_name = "/public/photos/image_placeholder.jpg";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="public/styles/site.css">
  <title>Plant Details</title>
</head>

<body>

  <h1>Playful Plants Project</h1>

  <div class="tile">
    <img src=<?php echo htmlspecialchars($file_name); ?> alt="Plant Image" width="400">
    <div class="tile-header">
      <h3><?php echo htmlspecialchars($record['plant_name_coll']); ?></h3>
      <h4><?php echo htmlspecialchars($record['plant_name_spec']); ?></h4>
    </div>
    <ul>
      <?php if ($record['exploratory_constructive_play']) { ?>
        <li>
          Supports Exploratory Constructive Play
        </li>
      <?php } ?>
      <?php if ($record['exploratory_sensory_play']) { ?>
        <li>
          Supports Exploratory Sensory Play
        </li>
      <?php } ?>
      <?php if ($record['physical_play']) { ?>
        <li>
          Supports Physical Play
        </li>
      <?php } ?>
      <?php if ($record['imaginative_play']) { ?>
        <li>
          Supports Imaginative Play
        </li>
      <?php } ?>
      <?php if ($record['restorative_play']) { ?>
        <li>
          Supports Restorative Play
        </li>
      <?php } ?>
      <?php if ($record['expressive_play']) { ?>
        <li>
          Supports Expressive Play
        </li>
      <?php } ?>
      <?php if ($record['play_with_rules']) { ?>
        <li>
          Supports Play with Rules
        </li>
      <?php } ?>
      <?php if ($record['bio_play']) { ?>
        <li>
          Supports Bio Play
        </li>
      <?php } ?>

    </ul>
    <div>
      Tags: <?php echo $tag_names ?>
    </div>
  </div>

  <div class="space">
    <a href="/">Go back to catalog</a>
  </div>

</body>

</html>
