<?php
$db = open_sqlite_db('tmp/site.sqlite');

// Feedback message classes:
$sort_filter_feedback_class = 'hidden';
$name_coll_feedback_class = 'hidden';
$name_spec_feedback_class = 'hidden';
$plant_id_feedback_class = 'hidden';
$play_type_feedback_class = 'hidden';

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


if (isset($_POST['add_plant'])) {
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

  if ($form_valid) {
    $result = exec_sql_query(
      $db,
      "INSERT INTO seed (plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play) VALUES (:plant_name_coll, :plant_name_spec, :plant_ID,:exploratory_constructive_play, :exploratory_sensory_play, :physical_play, :imaginative_play, :restorative_play, :expressive_play, :play_with_rules, :bio_play);",
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
        ':bio_play' => ($bio_play ? 1 : 0)
      )
    );

    if ($result) {
      $plant_inserted = True;
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

$sort_by = $_GET['radio_name'];
$filter_exploratory_constructive_play = (bool)($_GET['filter_exploratory_constructive_play'] ?? NULL);
$filter_exploratory_sensory_play = (bool)($_GET['filter_exploratory_sensory_play'] ?? NULL);
$filter_physical_play = (bool)($_GET['filter_physical_play'] ?? NULL);
$filter_imaginative_play = (bool)($_GET['filter_imaginative_play'] ?? NULL);
$filter_restorative_play = (bool)($_GET['filter_restorative_play'] ?? NULL);
$filter_expressive_play = (bool)($_GET['filter_expressive_play'] ?? NULL);
$filter_play_with_rules = (bool)($_GET['filter_play_with_rules'] ?? NULL);
$filter_bio_play = (bool)($_GET['filter_bio_play'] ?? NULL);

# Validate filter/sort form
if (
  isset($_GET['apply']) && empty($sort_by) && !$filter_exploratory_constructive_play && !$filter_exploratory_sensory_play
  && !$filter_physical_play && !$filter_imaginative_play && !$filter_restorative_play
  && !$filter_expressive_play && !$filter_play_with_rules && !$filter_bio_play
) {
  # The user clicked on the Apply button without providing any input.
  # No sort/filter criteria in the form are selected.
  $sort_filter_feedback_class = '';
  $records = exec_sql_query($db, 'SELECT * FROM seed')->fetchAll();
} else if (isset($_GET['reset'])) {
  # The user clicked on the Reset button.
  # Clear up sticky values.
  # Show whole catalog without any filters and sorting.

  $sticky_sort_asc = '';
  $sticky_sort_desc = '';
  $sticky_filter_name_coll = '';
  $sticky_filter_name_spec = '';
  $sticky_filter_exploratory_constructive_play = '';
  $sticky_filter_exploratory_sensory_play = '';
  $sticky_filter_physical_play = '';
  $sticky_filter_imaginative_play = '';
  $sticky_filter_restorative_play = '';
  $sticky_filter_expressive_play = '';
  $sticky_filter_play_with_rules = '';
  $sticky_filter_bio_play = '';

  $records = exec_sql_query($db, 'SELECT * FROM seed')->fetchAll();
} else {
  # Some sort/filter criteria in the form are selected.

  $sticky_sort_asc = ($sort_by == 'name_asc' ? 'checked' : '');
  $sticky_sort_desc = ($sort_by == 'name_desc' ? 'checked' : '');
  $sticky_filter_exploratory_constructive_play = (empty($filter_exploratory_constructive_play) ? '' : 'checked');
  $sticky_filter_exploratory_sensory_play = ($filter_exploratory_sensory_play ? 'checked' : '');
  $sticky_filter_physical_play = ($filter_physical_play ? 'checked' : '');
  $sticky_filter_imaginative_play = ($filter_imaginative_play ? 'checked' : '');
  $sticky_filter_restorative_play = ($filter_restorative_play ? 'checked' : '');
  $sticky_filter_expressive_play = ($filter_expressive_play ? 'checked' : '');
  $sticky_filter_play_with_rules = ($filter_play_with_rules ? 'checked' : '');
  $sticky_filter_bio_play = ($filter_bio_play ? 'checked' : '');

  $sql_select_part = 'SELECT * FROM seed';

  $sql_where_part = '';
  $sql_filter_expressions = array();

  if ($filter_exploratory_constructive_play) {
    array_push($sql_filter_expressions, "(exploratory_constructive_play = 1)");
  }

  if ($filter_exploratory_sensory_play) {
    array_push($sql_filter_expressions, "(exploratory_sensory_play = 1)");
  }

  if ($filter_physical_play) {
    array_push($sql_filter_expressions, "(physical_play = 1)");
  }

  if ($filter_imaginative_play) {
    array_push($sql_filter_expressions, "(imaginative_play = 1)");
  }

  if ($filter_restorative_play) {
    array_push($sql_filter_expressions, "(restorative_play = 1)");
  }

  if ($filter_expressive_play) {
    array_push($sql_filter_expressions, "(expressive_play = 1)");
  }

  if ($filter_play_with_rules) {
    array_push($sql_filter_expressions, "(play_with_rules = 1)");
  }

  if ($filter_bio_play) {
    array_push($sql_filter_expressions, "(bio_play = 1)");
  }

  if (count($sql_filter_expressions) > 0) {
    $sql_where_part = ' WHERE ' . implode(' AND ', $sql_filter_expressions);
  }

  if (empty($sort_by)) {
    $sql_order_part = ';';
  } else if ($sort_by == 'name_asc') {
    $sql_order_part = ' ORDER BY plant_name_coll ASC;';
  } else if ($sort_by == 'name_desc') {
    $sql_order_part = ' ORDER BY plant_name_coll DESC;';
  }


  // build the final query
  $sql_query = $sql_select_part . $sql_where_part . $sql_order_part;
  $records = exec_sql_query($db, $sql_query)->fetchAll();
}


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
    <div class="column left">
      <h2>Sort and Filter Catalog</h2>
      <form method="get" action="/" novalidate>
        <div class="feedback <?php echo $sort_filter_feedback_class; ?>">Please select a sort order and/or filter.</div>
        <div role="group" class="sort-filter-criteria">
          <h3>Sort by:</h3>
          <div>
            <div class="label-input">
              <input type="radio" id="radio_name_asc" name="radio_name" value="name_asc" <?php echo $sticky_sort_asc; ?> />
              <label for="radio_name_asc">Colloquial name (ascending)</label>
            </div>

            <div>
              <input type="radio" id="radio_name_desc" name="radio_name" value="name_desc" <?php echo $sticky_sort_desc; ?> />
              <label for="radio_name_desc">Colloquial name (descending)</label>
            </div>
          </div>
        </div>

        <!-- <h3>Filter by Play Type:</h3> -->
        <div role="group" class="sort-filter-criteria">
          <h3>Filter by Play Type:</h3>
          <div>
            <input type="checkbox" id="filter_exploratory_constructive_play" name="filter_exploratory_constructive_play" <?php echo $sticky_filter_exploratory_constructive_play; ?> />
            <label for="filter_exploratory_constructive_play">Supports Exploratory Constructive Play</label>
          </div>

          <div>
            <input type="checkbox" id="filter_exploratory_sensory_play" name="filter_exploratory_sensory_play" <?php echo $sticky_filter_exploratory_sensory_play; ?> />
            <label for="filter_exploratory_sensory_play">Supports Exploratory Sensory Play</label>
          </div>

          <div>
            <input type="checkbox" id="filter_physical_play" name="filter_physical_play" <?php echo $sticky_filter_physical_play; ?> />
            <label for="filter_physical_play">Supports Physical Play</label>
          </div>

          <div>
            <input type="checkbox" id="filter_imaginative_play" name="filter_imaginative_play" <?php echo $sticky_filter_imaginative_play; ?> />
            <label for="filter_imaginative_play">Supports Imaginative Play</label>
          </div>

          <div>
            <input type="checkbox" id="filter_restorative_play" name="filter_restorative_play" <?php echo $sticky_filter_restorative_play; ?> />
            <label for="filter_restorative_play">Supports Restorative Play</label>
          </div>

          <div>
            <input type="checkbox" id="filter_expressive_play" name="filter_expressive_play" <?php echo $sticky_filter_expressive_play; ?> />
            <label for="filter_expressive_play">Supports Expressive Play</label>
          </div>

          <div>
            <input type="checkbox" id="filter_play_with_rules" name="filter_play_with_rules" <?php echo $sticky_filter_play_with_rules; ?> />
            <label for="filter_play_with_rules">Supports Play with Rules</label>
          </div>

          <div>
            <input type="checkbox" id="filter_bio_play" name="filter_bio_play" <?php echo $sticky_filter_bio_play; ?> />
            <label for="filter_bio_play">Supports Bio Play</label>
          </div>
        </div>

        <div>
          <input type="submit" name="apply" value="Apply">
          <input type="submit" name="reset" value="Reset">
        </div>
      </form>


      <h2>Add Plant</h2>
      <form method="post" action="/" novalidate>

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
          <input type="submit" name="add_plant" value="Add">
        </div>
      </form>

    </div>
    <div class="column right">
      <?php if ($plant_inserted) { ?>
        <p class="add-confirm">Thank you for adding a plant to our catalog!</p>
      <?php } ?>
      <h2>Plant Catalog</h2>
      <div class="catalog">
        <ul>
          <?php
          foreach ($records as $record) { ?>
            <li class="tile">
              <div class="tile-header">
                <h3><?php echo htmlspecialchars($record['plant_name_coll']); ?></h3>
                <h4><?php echo htmlspecialchars($record['plant_name_spec']); ?></h4>
                <h5>Plant ID: <?php echo htmlspecialchars($record['plant_ID']); ?></h5>
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
            </li>
            <hr>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>

</body>

</html>
