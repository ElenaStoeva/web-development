<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="public/styles/site.css">
  <title>Login</title>
</head>

<body>

  <h1>Playful Plants Project</h1>


  <div>

    <form action="/admin" method="post">

      <div>
        <label for="username"><b>Username: </b></label>
        <input type="text" name="username" required>

        <label for="password"><b>Password: </b></label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
      </div>

    </form>
  </div>

</body>

</html>
