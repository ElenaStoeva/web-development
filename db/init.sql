--- Plants Table ---

CREATE TABLE plants (
	id	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	plant_name_coll TEXT NOT NULL,
  plant_name_spec TEXT NOT NULL UNIQUE,
  plant_ID TEXT NOT NULL UNIQUE,
  exploratory_constructive_play INTEGER NOT NULL,
  exploratory_sensory_play INTEGER NOT NULL,
  physical_play INTEGER NOT NULL,
  imaginative_play INTEGER NOT NULL,
  restorative_play INTEGER NOT NULL,
  expressive_play INTEGER NOT NULL,
  play_with_rules INTEGER NOT NULL,
  bio_play INTEGER NOT NULL
);

--- Initial plant records ---

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (1, '3 Sisters-Corn', 'Red Mohawk Corn', 'FE_07', 0, 1, 1, 1, 1, 0, 1, 0);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (2, 'American Groundnut', 'Apius americana', 'VI_05', 0, 1, 1, 1, 0, 0, 0, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (3, 'Common Nasturtiums', 'Tropaeolum (group)', 'VI_01', 0, 1, 0, 1, 0, 0, 0, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (4, 'Downy skullcap', 'Scutellaria incana', 'FL_28', 0, 1, 0, 1, 0, 0, 0, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (5, 'White Turtlehead', 'Chelone glabra', 'FL_10', 0, 1, 0, 1, 0, 0, 0, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (6, 'Blue Grama Grass', 'Bouteloua gracilis', 'GA_12', 1, 1, 1, 0, 0, 0, 0, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (7, 'Feather Moss', 'Hypnum imponens', 'FE_16', 0, 1, 0, 1, 1, 0, 0, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (8, 'Cattails', 'Typha latifolia', 'GA_14-W', 1, 1, 1, 1, 1, 0, 0, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (9, 'American Persimmon', 'Diospyros virginiana', 'TR_14', 1, 1, 1, 0, 0, 0, 0, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (10, 'Northern BayberryÂ ', 'Myrica pensylvanica', 'SH_04', 0, 1, 1, 0, 1, 0, 1, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (11, 'Russian Sage', 'Perovskia atriplicifolia', 'FL_18', 0, 1, 0, 0, 0, 0, 0, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (12, 'Chinese Chestnuts', 'Castanea mollissima', 'TR_16', 1, 1, 1, 1, 1, 0, 0, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (13, 'Cranesbill', 'Geranium maculatum', 'FL_04', 0, 1, 0, 0, 0, 0, 0, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (14, 'Jack-in-the-Pulpit', 'Arisaema triphyllum', 'FL_36', 0, 1, 1, 1, 0, 0, 0, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (15, 'Dappled WillowÂ', "Salix integra 'Hakuro Nishiki", 'SH_08', 0, 1, 1, 1, 1, 0, 1, 1);

INSERT INTO
  plants (id, plant_name_coll, plant_name_spec, plant_ID, exploratory_constructive_play, exploratory_sensory_play, physical_play, imaginative_play, restorative_play, expressive_play, play_with_rules, bio_play)
VALUES
  (16, 'Sensitive Fern', 'Onodea sensibilis', 'FE_03', 0, 1, 0, 0, 1, 0, 0, 0);


--- Tags Table ---

CREATE TABLE tags (
	tag_id	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	tag_name TEXT NOT NULL UNIQUE
);

--- Initial tag records ---

INSERT INTO
  tags (tag_id, tag_name)
VALUES
  (1, 'Shrub');

INSERT INTO
  tags (tag_id, tag_name)
VALUES
  (2, 'Grass');

INSERT INTO
  tags (tag_id, tag_name)
VALUES
  (3, 'Vine');

INSERT INTO
  tags (tag_id, tag_name)
VALUES
  (4, 'Tree');

INSERT INTO
  tags (tag_id, tag_name)
VALUES
  (5, 'Flower');

INSERT INTO
  tags (tag_id, tag_name)
VALUES
  (6, 'Groundcover');

INSERT INTO
  tags (tag_id, tag_name)
VALUES
  (7, 'Other');


--- Tagging Table ---

CREATE TABLE plant_tags (
	id	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  plant_id TEXT NOT NULL,
	tag_id TEXT NOT NULL,
  FOREIGN KEY (plant_id) REFERENCES plants(id),
  FOREIGN KEY (tag_id) REFERENCES tags(tag_id),
  UNIQUE(plant_id,tag_id)
);

--- Initial tagging records ---

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (1, 1, 7);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (2, 2, 3);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (3, 3, 3);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (4, 4, 5);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (5, 5, 5);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (6, 6, 2);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (7, 7, 7);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (8, 8, 2);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (9, 9, 4);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (10, 10, 1);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (11, 11, 5);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (12, 12, 4);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (13, 13, 5);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (14, 14, 5);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (15, 15, 1);

INSERT INTO
  plant_tags (id, plant_id, tag_id)
VALUES
  (16, 16, 7);

--- Users Table ---

CREATE TABLE users (
	id	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL UNIQUE
);

--- Initial user records ---

-- password: monkey
INSERT INTO
  users (id, username, password)
VALUES
  (1, 'admin', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.');


--- Sessions ---
CREATE TABLE sessions (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  user_id INTEGER NOT NULL,
  session TEXT NOT NULL UNIQUE,
  last_login TEXT NOT NULL,
  FOREIGN KEY(user_id) REFERENCES users(id)
);
