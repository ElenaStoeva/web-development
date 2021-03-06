<?php

// --- Define Variables ---

$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');
define("MAX_FILE_SIZE", 1000000);

// Check if user is logged in

if (is_user_logged_in()) {


  // Feedback message classes:
  $sort_filter_feedback_class = 'hidden';
  $name_coll_feedback_class = 'hidden';
  $name_spec_feedback_class = 'hidden';
  $plant_id_feedback_class = 'hidden';
  $play_type_feedback_class = 'hidden';
  $file_feedback_class = 'hidden';

  $plant_updated = False;

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
  $sticky_shrub_tag = '';
  $sticky_grass_tag = '';
  $sticky_vine_tag = '';
  $sticky_tree_tag = '';
  $sticky_flower_tag = '';
  $sticky_groundcover_tag = '';
  $sticky_other_tag = '';

  $update_id = $_POST['update-id'] ?? NULL;
  $get_id = $_GET['edit-plant'];

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
    $shrub_tag = (bool)($_POST['shrub_tag'] ?? NULL);
    $grass_tag = (bool)($_POST['grass_tag'] ?? NULL);
    $vine_tag = (bool)($_POST['vine_tag'] ?? NULL);
    $tree_tag = (bool)($_POST['tree_tag'] ?? NULL);
    $flower_tag = (bool)($_POST['flower_tag'] ?? NULL);
    $groundcover_tag = (bool)($_POST['groundcover_tag'] ?? NULL);
    $other_tag = (bool)($_POST['other_tag'] ?? NULL);

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
        $file_feedback_class = '';
      }
    } else {
      // Something is uploaded but is wrong format/size
      if ($upload['name'] != "") {
        $form_valid = False;
        $file_feedback_class = '';
      }
    }

    if ($form_valid) {
      $result = exec_sql_query(
        $db,
        "UPDATE plants
    SET plant_name_coll = :plant_name_coll, plant_name_spec = :plant_name_spec, plant_ID = :plant_ID, exploratory_constructive_play = :exploratory_constructive_play, exploratory_sensory_play = :exploratory_sensory_play, physical_play = :physical_play,
    imaginative_play = :imaginative_play, restorative_play = :restorative_play, expressive_play = :expressive_play, play_with_rules = :play_with_rules, bio_play = :bio_play
    WHERE plants.id = :id;",
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

      $plant_updated = True;

      $updated_records = exec_sql_query(
        $db,
        "SELECT plants.id, plant_name_coll, plant_name_spec, plants.plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play, tag_name FROM plants LEFT OUTER JOIN plant_tags ON plants.id = plant_tags.plant_id LEFT OUTER JOIN tags ON plant_tags.tag_id = tags.tag_id WHERE (plants.id = :id);",
        array(
          ':id' => $update_id
        )
      )->fetchAll();


      $old_tags = array();
      foreach ($updated_records as $record) {
        array_push($old_tags, $record['tag_name']);
      }

      if ($shrub_tag) {
        if (!in_array('Shrub', $old_tags)) {
          exec_sql_query(
            $db,
            "INSERT INTO plant_tags (plant_id, tag_id) VALUES (:plant_id, :tag_id);",
            array(
              ':plant_id' => $update_id,
              ':tag_id' => 1
            )
          );
        }
      } else {
        exec_sql_query(
          $db,
          "DELETE FROM plant_tags WHERE plant_id = :plant_id AND tag_id = :tag_id;",
          array(
            ':plant_id' => $update_id,
            ':tag_id' => 1
          )
        );
      }

      if ($grass_tag) {
        if (!in_array('Grass', $old_tags)) {
          exec_sql_query(
            $db,
            "INSERT INTO plant_tags (plant_id, tag_id) VALUES (:plant_id, :tag_id);",
            array(
              ':plant_id' => $update_id,
              ':tag_id' => 2
            )
          );
        }
      } else {
        exec_sql_query(
          $db,
          "DELETE FROM plant_tags WHERE plant_id = :plant_id AND tag_id = :tag_id;",
          array(
            ':plant_id' => $update_id,
            ':tag_id' => 2
          )
        );
      }

      if ($vine_tag) {
        if (!in_array('Vine', $old_tags)) {
          exec_sql_query(
            $db,
            "INSERT INTO plant_tags (plant_id, tag_id) VALUES (:plant_id, :tag_id);",
            array(
              ':plant_id' => $update_id,
              ':tag_id' => 3
            )
          );
        }
      } else {
        exec_sql_query(
          $db,
          "DELETE FROM plant_tags WHERE plant_id = :plant_id AND tag_id = :tag_id;",
          array(
            ':plant_id' => $update_id,
            ':tag_id' => 3
          )
        );
      }

      if ($tree_tag) {
        if (!in_array('Tree', $old_tags)) {
          exec_sql_query(
            $db,
            "INSERT INTO plant_tags (plant_id, tag_id) VALUES (:plant_id, :tag_id);",
            array(
              ':plant_id' => $update_id,
              ':tag_id' => 4
            )
          );
        }
      } else {
        exec_sql_query(
          $db,
          "DELETE FROM plant_tags WHERE plant_id = :plant_id AND tag_id = :tag_id;",
          array(
            ':plant_id' => $update_id,
            ':tag_id' => 4
          )
        );
      }

      if ($flower_tag) {
        if (!in_array('Flower', $old_tags)) {
          exec_sql_query(
            $db,
            "INSERT INTO plant_tags (plant_id, tag_id) VALUES (:plant_id, :tag_id);",
            array(
              ':plant_id' => $update_id,
              ':tag_id' => 5
            )
          );
        }
      } else {
        exec_sql_query(
          $db,
          "DELETE FROM plant_tags WHERE plant_id = :plant_id AND tag_id = :tag_id;",
          array(
            ':plant_id' => $update_id,
            ':tag_id' => 5
          )
        );
      }

      if ($groundcover_tag) {
        if (!in_array('Groundcover', $old_tags)) {
          exec_sql_query(
            $db,
            "INSERT INTO plant_tags (plant_id, tag_id) VALUES (:plant_id, :tag_id);",
            array(
              ':plant_id' => $update_id,
              ':tag_id' => 6
            )
          );
        }
      } else {
        exec_sql_query(
          $db,
          "DELETE FROM plant_tags WHERE plant_id = :plant_id AND tag_id = :tag_id;",
          array(
            ':plant_id' => $update_id,
            ':tag_id' => 6
          )
        );
      }

      if ($other_tag) {
        if (!in_array('Other', $old_tags)) {
          exec_sql_query(
            $db,
            "INSERT INTO plant_tags (plant_id, tag_id) VALUES (:plant_id, :tag_id);",
            array(
              ':plant_id' => $update_id,
              ':tag_id' => 7
            )
          );
        }
      } else {
        exec_sql_query(
          $db,
          "DELETE FROM plant_tags WHERE plant_id = :plant_id AND tag_id = :tag_id;",
          array(
            ':plant_id' => $update_id,
            ':tag_id' => 7
          )
        );
      }

      if ($result && $upload['name'] != "") {
        $id_filename = 'public/uploads/plants/' . $plant_id . '.' . $upload_ext;
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
      $sticky_shrub_tag = (!$shrub_tag ? '' : 'checked');
      $sticky_grass_tag = (!$grass_tag ? '' : 'checked');
      $sticky_vine_tag = (!$vine_tag ? '' : 'checked');
      $sticky_tree_tag = (!$tree_tag ? '' : 'checked');
      $sticky_flower_tag = (!$flower_tag ? '' : 'checked');
      $sticky_groundcover_tag = (!$groundcover_tag ? '' : 'checked');
      $sticky_other_tag = (!$other_tag ? '' : 'checked');
    }
  }
}


if ($update_id) {

  $records = exec_sql_query(
    $db,
    "SELECT plants.id, plant_name_coll, plant_name_spec, plants.plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play, tag_name FROM plants LEFT OUTER JOIN plant_tags ON plants.id = plant_tags.plant_id LEFT OUTER JOIN tags ON plant_tags.tag_id = tags.tag_id WHERE (plants.id = :id);",
    array(
      ':id' => $update_id
    )
  )->fetchAll();

  if (count($records) > 0) {
    $record = $records[0];
  }
} else if ($get_id) {

  $records = exec_sql_query(
    $db,
    "SELECT plants.id, plant_name_coll, plant_name_spec, plants.plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play, tag_name FROM plants LEFT OUTER JOIN plant_tags ON plants.id = plant_tags.plant_id LEFT OUTER JOIN tags ON plant_tags.tag_id = tags.tag_id WHERE (plants.id = :id);",
    array(
      ':id' => $get_id
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

  if (!$update_id || $form_valid) {
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

  $file_name_uploads = "./public/uploads/plants/" . $record['plant_ID'] . ".jpg";
  $file_name_photos = "./public/photos/" . $record['plant_ID'] . ".jpg";
  // Image Source: (original work) Elena Stoeva
  $file_name = "/public/photos/image_placeholder.jpg";
  if (file_exists($file_name_uploads)) {
    $file_name = $file_name_uploads;
  } else if (file_exists($file_name_photos)) {
    $file_name = $file_name_photos;
  }

  $tags = array();
  foreach ($records as $record) {
    array_push($tags, $record['tag_name']);
  }

  $sticky_shrub_tag = (!in_array('Shrub', $tags) ? '' : 'checked');
  $sticky_grass_tag = (!in_array('Grass', $tags) ? '' : 'checked');
  $sticky_vine_tag = (!in_array('Vine', $tags) ? '' : 'checked');
  $sticky_tree_tag = (!in_array('Tree', $tags) ? '' : 'checked');
  $sticky_flower_tag = (!in_array('Flower', $tags) ? '' : 'checked');
  $sticky_groundcover_tag = (!in_array('Groundcover', $tags) ? '' : 'checked');
  $sticky_other_tag = (!in_array('Other', $tags) ? '' : 'checked');
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
  <?php
  if (is_user_logged_in()) { ?>

    <button onclick="location.href='<?php echo logout_url(); ?>';">Log Out</button>
    <?php if ($plant_updated) { ?>
      <p class="add-confirm">The plant has been updated!</p>
    <?php } ?>
    <div class="tile">
      <img src=<?php echo htmlspecialchars($file_name); ?> alt="Plant Image" width="400">
      <form action="/edit?<?php echo http_build_query(array('edit-plant' => $get_id)); ?>" method="post" enctype="multipart/form-data" novalidate>

        <div class="form-input">
          <div class="feedback <?php echo $name_coll_feedback_class; ?>">Please enter a valid colloquial plant name.</div>
          <label for="plant-name-coll">Plant name (colloquial):</label>
          <input id="plant-name-coll" type="text" name="plant-name-coll" value="<?php echo htmlspecialchars($sticky_name_coll); ?>">
        </div>

        <div class="form-input">
          <div class="feedback <?php echo $name_spec_feedback_class; ?>">Please enter a valid scientific plant name.</div>
          <label for="plant-name-spec">Plant name (genus, species):</label>
          <input id="plant-name-spec" type="text" name="plant-name-spec" value="<?php echo htmlspecialchars($sticky_name_spec); ?>">
        </div>

        <div class="form-input">
          <div class="feedback <?php echo $plant_id_feedback_class; ?>">Please enter a valid plant ID.</div>
          <label for="plant-id">Plant ID:</label>
          <input id="plant-id" type="text" name="plant-id" value=" <?php echo htmlspecialchars($sticky_plant_id); ?>">
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

        <div>Tags:</div>
        <div role="group">
          <div>
            <input type="checkbox" id="shrub_tag" name="shrub_tag" <?php echo $sticky_shrub_tag; ?> />
            <label for="shrub_tag">Shrub</label>
          </div>

          <div>
            <input type="checkbox" id="grass_tag" name="grass_tag" <?php echo $sticky_grass_tag; ?> />
            <label for="grass_tag">Grass</label>
          </div>

          <div>
            <input type="checkbox" id="vine_tag" name="vine_tag" <?php echo $sticky_vine_tag; ?> />
            <label for="vine_tag">Vine</label>
          </div>

          <div>
            <input type="checkbox" id="tree_tag" name="tree_tag" <?php echo $sticky_tree_tag; ?> />
            <label for="tree_tag">Tree</label>
          </div>

          <div>
            <input type="checkbox" id="flower_tag" name="flower_tag" <?php echo $sticky_flower_tag; ?> />
            <label for="flower_tag">Flower</label>
          </div>

          <div>
            <input type="checkbox" id="groundcover_tag" name="groundcover_tag" <?php echo $sticky_groundcover_tag; ?> />
            <label for="groundcover_tag">Groundcover</label>
          </div>

          <div>
            <input type="checkbox" id="other_tag" name="other_tag" <?php echo $sticky_other_tag; ?> />
            <label for="other_tag">Other</label>
          </div>
        </div>

        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />

        <p class="feedback <?php echo $file_feedback_class; ?>">Please select a valid JPG file.</p>
        <div class="label-input space">
          <label for="upload-file">Upload JPG Image:</label>
          <input id="upload-file" type="file" name="jpg-file" accept=".jpg" />
        </div>
        <div class="label-input space">
          <input type="hidden" name="update-id" value="<?php echo $record['id']; ?>" />


          <button type="submit">Save Changes</button>
        </div>
      </form>
    </div>
    <div class="space">
      <a href="/admin">Go back to catalog</a>
    </div>
  <?php
  } else {
  ?>

    <p>Yon need to be an administrator to access this page. Please login with your credentials.</p>

    <?php
    echo_login_form('/admin', $session_messages);
    ?>

    <p>If you don't have an account and would like to volunteer for this project by being an administrator, please contact us at <a href="mailto:someone@yoursite.com">playfulplantsproject@gmail.com</a>.</p>

    <div class="space">
      <a href="/">Go back to catalog</a>
    </div>

  <?php
  }
  ?>

</body>

</html>
