<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="jokes.css">
    <title><?php echo $title; ?></title>
  </head>
  <body>
    <header>Internet Joke Database</header>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="jokes.php">Jokes List</a></li>
        <li><a href="addjoke.php">Add a new joke</a></li>
      </ul>
    </nav>
    <main>
      <?php echo $output; ?>
    </main>
    <footer>© IJDB 2023</footer>
  </body>
</html>