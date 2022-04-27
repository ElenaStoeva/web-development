<?php

$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');

define("MAX_FILE_SIZE", 1000000);

// Feedback message classes:
$sort_filter_feedback_class = 'hidden';
$name_coll_feedback_class = 'hidden';
$name_spec_feedback_class = 'hidden';
$plant_id_feedback_class = 'hidden';
$play_type_feedback_class = 'hidden';
$file_feedback_class = 'hidden';

$plant_inserted = False;

// Sticky values:
$sticky_name_coll = '';
$sticky_name_spec = '';
$sticky_plant_id = '';
$sticky_exploratory_constructive_play = '';
$sticky_exploratory_sensory_play = '';
$sticky_physical_play = '';
$sticky_imaginative_play = '';
$sticky_restorative_play = '';
$sticky_expressive_play = '';
$sticky_play_with_rules = '';
$sticky_bio_play = '';

$update_id = $_POST['update-id'] ?? NULL;

$plant_id = $_GET['edit-plant'];


if ($update_id) {

  $records = exec_sql_query(
    $db,
    "SELECT * FROM plants LEFT OUTER JOIN plant_tags ON plants.id = plant_tags.plant_id LEFT OUTER JOIN tags ON plant_tags.tag_id = tags.tag_id WHERE (plants.plant_ID = :id);",
    array(
      ':id' => $update_id
    )
  )->fetchAll();

  if (count($records) > 0) {
    $record = $records[0];
  }
} else if ($plant_id) {

  $records = exec_sql_query(
    $db,
    "SELECT * FROM plants LEFT OUTER JOIN plant_tags ON plants.id = plant_tags.plant_id LEFT OUTER JOIN tags ON plant_tags.tag_id = tags.tag_id WHERE (plants.plant_ID = :id);",
    array(
      ':id' => $plant_id
    )
  )->fetchAll();

  if (count($records) > 0) {
    $record = $records[0];
  }
}

if ($record) {
  $name_coll = $record['plant_name_coll'];
  $name_spec = $record['plant_name_spec'];
  $plant_id = $record['plant_ID'];
  $exploratory_constructive_play = (bool)($record['exploratory_constructive_play']);
  $exploratory_sensory_play = (bool)($record['exploratory_sensory_play']);
  $physical_play = (bool)($record['physical_play']);
  $imaginative_play = (bool)($record['imaginative_play']);
  $restorative_play = (bool)($record['restorative_play']);
  $expressive_play = (bool)($record['expressive_play']);
  $play_with_rules = (bool)($record['play_with_rules']);
  $bio_play = (bool)($record['bio_play']);

  $sticky_name_coll = $name_coll;
  $sticky_name_spec = $name_spec;
  $sticky_plant_id = $plant_id;
  $sticky_exploratory_constructive_play = (!$exploratory_constructive_play ? '' : 'checked');
  $sticky_exploratory_sensory_play = (!$exploratory_sensory_play ? '' : 'checked');
  $sticky_physical_play = (!$physical_play ? '' : 'checked');
  $sticky_imaginative_play = (!$imaginative_play ? '' : 'checked');
  $sticky_restorative_play = (!$restorative_play ? '' : 'checked');
  $sticky_expressive_play = (!$expressive_play ? '' : 'checked');
  $sticky_play_with_rules = (!$play_with_rules ? '' : 'checked');
  $sticky_bio_play = (!$bio_play ? '' : 'checked');


  $file_name = "./public/photos/" . $record['plant_ID'] . ".jpg";
  if (!file_exists($file_name)) {
    // Image Source: (original work) Elena Stoeva
    $file_name = "/public/photos/image_placeholder.jpg";
  }


  // --- Update Plant ---

  if ($update_id) {

    $name_coll = trim($_POST['plant-name-coll']);
    $name_spec = trim($_POST['plant-name-spec']);
    $plant_id = trim($_POST['plant-id']);
    $exploratory_constructive_play = (bool)($_POST['exploratory_constructive_play'] ?? NULL);
    $exploratory_sensory_play = (bool)($_POST['exploratory_sensory_play'] ?? NULL);
    $physical_play = (bool)($_POST['physical_play'] ?? NULL);
    $imaginative_play = (bool)($_POST['imaginative_play'] ?? NULL);
    $restorative_play = (bool)($_POST['restorative_play'] ?? NULL);
    $expressive_play = (bool)($_POST['expressive_play'] ?? NULL);
    $play_with_rules = (bool)($_POST['play_with_rules'] ?? NULL);
    $bio_play = (bool)($_POST['bio_play'] ?? NULL);

    $form_valid = True;

    if (empty($name_coll)) {
      $form_valid = False;
      $name_coll_feedback_class = '';
    }

    if (empty($name_spec)) {
      $form_valid = False;
      $name_spec_feedback_class = '';
    }

    if (empty($plant_id)) {
      $form_valid = False;
      $plant_id_feedback_class = '';
    }

    // The plant should support at least one type of play
    if (
      !$exploratory_constructive_play && !$exploratory_sensory_play
      && !$physical_play && !$imaginative_play && !$restorative_play
      && !$expressive_play && !$play_with_rules && !$bio_play
    ) {
      $form_valid = False;
      $play_type_feedback_class = '';
    }


    // --- Handle Uploads ---

    $upload = $_FILES['jpg-file'];

    if ($upload['error'] == UPLOAD_ERR_OK) {
      $upload_filename = basename($upload['name']);
      $upload_ext = strtolower(pathinfo($upload_filename, PATHINFO_EXTENSION));

      // This site only accepts JPG files
      if (!in_array($upload_ext, array("jpg"))) {
        $form_valid = False;
      }
    } else {
      $form_valid = False;
    }

    if ($form_valid) {
      $result = exec_sql_query(
        $db,
        "UPDATE plants
        SET plant_name_coll = :plant_name_coll, plant_name_spec = :plant_name_spec, plant_ID = :plant_ID, exploratory_constructive_play = :exploratory_constructive_play, exploratory_sensory_play = :exploratory_sensory_play, physical_play = :physical_play,
        imaginative_play = :imaginative_play, restorative_play = :restorative_play, expressive_play = :expressive_play, play_with_rules = :play_with_rules, bio_play = :bio_play
        WHERE plant_ID = :id;",
        array(
          ':plant_name_coll' => $name_coll,
          ':plant_name_spec' => $name_spec,
          ':plant_ID' => $plant_id,
          ':exploratory_constructive_play' => ($exploratory_constructive_play ? 1 : 0),
          ':exploratory_sensory_play' => ($exploratory_sensory_play ? 1 : 0),
          ':physical_play' => ($physical_play ? 1 : 0),
          ':imaginative_play' => ($imaginative_play ? 1 : 0),
          ':restorative_play' => ($restorative_play ? 1 : 0),
          ':expressive_play' => ($expressive_play ? 1 : 0),
          ':play_with_rules' => ($play_with_rules ? 1 : 0),
          ':bio_play' => ($bio_play ? 1 : 0),
          ':id' => $update_id
        )
      );

      if ($result) {
        $id_filename = 'public/photos/' . $plant_id . '.' . $upload_ext;
        move_uploaded_file($upload["tmp_name"], $id_filename);
      }
    } else {
      $sticky_name_coll = $name_coll;
      $sticky_name_spec = $name_spec;
      $sticky_plant_id = $plant_id;
      $sticky_exploratory_constructive_play = (!$exploratory_constructive_play ? '' : 'checked');
      $sticky_exploratory_sensory_play = (!$exploratory_sensory_play ? '' : 'checked');
      $sticky_physical_play = (!$physical_play ? '' : 'checked');
      $sticky_imaginative_play = (!$imaginative_play ? '' : 'checked');
      $sticky_restorative_play = (!$restorative_play ? '' : 'checked');
      $sticky_expressive_play = (!$expressive_play ? '' : 'checked');
      $sticky_play_with_rules = (!$play_with_rules ? '' : 'checked');
      $sticky_bio_play = (!$bio_play ? '' : 'checked');
    }
  }
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
    <form action="/edit?<?php echo http_build_query(array('edit-plant' => $plant_id)); ?>" method="post" enctype="multipart/form-data" novalidate>

      <div class="form-input">
        <div class="feedback <?php echo $name_coll_feedback_class; ?>">Please enter a colloquial plant name.</div>
        <label for="plant-name-coll">Plant name (colloquial):</label>
        <input id="plant-name-coll" type="text" name="plant-name-coll" value="<?php echo htmlspecialchars($sticky_name_coll); ?>">
      </div>

      <div class="form-input">
        <div class="feedback <?php echo $name_spec_feedback_class; ?>">Please enter a scientific plant name.</div>
        <label for="plant-name-spec">Plant name (genus, species):</label>
        <input id="plant-name-spec" type="text" name="plant-name-spec" value="<?php echo htmlspecialchars($sticky_name_spec); ?>">
      </div>

      <div class="form-input">
        <div class="feedback <?php echo $plant_id_feedback_class; ?>">Please enter a plant ID.</div>
        <label for="plant-id">Plant ID:</label>
        <input id="plant-id" type=" text" name="plant-id" value=" <?php echo htmlspecialchars($sticky_plant_id); ?>">
      </div>

      <div role="group" class="form-input">
        <div class="feedback <?php echo $play_type_feedback_class; ?>">Please select at least one type of play.</div>
        <div>Play Type Categorization:</div>

        <div role="group">
          <div>
            <input type="checkbox" id="exploratory_constructive_play" name="exploratory_constructive_play" <?php echo $sticky_exploratory_constructive_play; ?> />
            <label for="exploratory_constructive_play">Supports Exploratory Constructive Play</label>
          </div>

          <div>
            <input type="checkbox" id="exploratory_sensory_play" name="exploratory_sensory_play" <?php echo $sticky_exploratory_sensory_play; ?> />
            <label for="exploratory_sensory_play">Supports Exploratory Sensory Play</label>
          </div>

          <div>
            <input type="checkbox" id="physical_play" name="physical_play" <?php echo $sticky_physical_play; ?> />
            <label for="physical_play">Supports Physical Play</label>
          </div>

          <div>
            <input type="checkbox" id="imaginative_play" name="imaginative_play" <?php echo $sticky_imaginative_play; ?> />
            <label for="imaginative_play">Supports Imaginative Play</label>
          </div>

          <div>
            <input type="checkbox" id="restorative_play" name="restorative_play" <?php echo $sticky_restorative_play; ?> />
            <label for="restorative_play">Supports Restorative Play</label>
          </div>

          <div>
            <input type="checkbox" id="expressive_play" name="expressive_play" <?php echo $sticky_expressive_play; ?> />
            <label for="expressive_play">Supports Expressive Play</label>
          </div>

          <div>
            <input type="checkbox" id="play_with_rules" name="play_with_rules" <?php echo $sticky_play_with_rules; ?> />
            <label for="play_with_rules">Supports Play with Rules</label>
          </div>

          <div>
            <input type="checkbox" id="bio_play" name="bio_play" <?php echo $sticky_bio_play; ?> />
            <label for="bio_play">Supports Bio Play</label>
          </div>
        </div>
      </div>

      <div>
        Tag:
        <select name="tag">
          <option value="tag" selected><?php echo htmlspecialchars($record['tag_name']) ?></option>
          <?php
          $tags = ['Shrub', 'Grass', 'Vine', 'Tree', 'Flower', 'Groundcover', 'Other'];
          foreach ($tags as $tag) {
            if ($tag != $record['tag_name']) { ?>
              <option value="tag"><?php echo htmlspecialchars($tag) ?></option>
          <?php
            }
          } ?>
        </select>
      </div>

      <input type="hidden" name="update-id" value="<?php echo htmlspecialchars($plant_id); ?>" />

      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />

      <p class="feedback <?php echo $file_feedback_class; ?>">Please select a JPG file.</p>
      <div class="label-input">
        <label for="upload-file">Upload JPG Image:</label>
        <input id="upload-file" type="file" name="jpg-file" accept=".jpg" />
      </div>

      <div>
        <button type="submit">Save Changes</button>
      </div>
    </form>
  </div>

  <a href="/admin">Go back to catalog</a>

</body>

</html>
