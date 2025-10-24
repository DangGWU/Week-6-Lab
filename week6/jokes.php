<?php
try {
    include 'includes/DatabaseConnection.php';

    $sql = 'SELECT jokes.ID, joketext, jokedate, jokeimage, author.name, author.email
            FROM jokes
            INNER JOIN author ON jokes.authorid = author.id';
    $jokes = $pdo->query($sql);
    $title = 'Joke list';

    ob_start();
    include 'templates/jokes.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
}

include 'templates/layout.html.php';
