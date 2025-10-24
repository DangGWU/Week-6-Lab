<?php
if (isset($_POST['joketext'], $_POST['name'], $_POST['email'])) {
    try {
        include 'includes/DatabaseConnection.php';

        // --- 1. Handle image upload ---
        $imagePath = null;
        if (isset($_FILES['jokeimage']) && $_FILES['jokeimage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileTmpPath = $_FILES['jokeimage']['tmp_name'];
            $fileName = basename($_FILES['jokeimage']['name']);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'jfif'];

            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = uniqid('joke_', true) . '.' . $fileExtension;
                $destPath = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $imagePath = $destPath;
                } else {
                    throw new Exception('Error moving uploaded file.');
                }
            } else {
                throw new Exception('Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.');
            }
        }

        // --- 2. Handle author ---
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);

        // Check if author already exists
        $authorQuery = 'SELECT id FROM author WHERE email = :email';
        $stmt = $pdo->prepare($authorQuery);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $author = $stmt->fetch();

        if ($author) {
            $authorId = $author['id'];
        } else {
            $insertAuthor = 'INSERT INTO author (name, email) VALUES (:name, :email)';
            $stmt = $pdo->prepare($insertAuthor);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $authorId = $pdo->lastInsertId();
        }

        // --- 3. Insert the joke ---
        $sql = 'INSERT INTO jokes 
                (joketext, jokedate, jokeimage, authorid)
                VALUES (:joketext, CURDATE(), :jokeimage, :authorid)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':joketext', $_POST['joketext']);
        $stmt->bindValue(':jokeimage', $imagePath);
        $stmt->bindValue(':authorid', $authorId);
        $stmt->execute();

        // --- 4. Redirect back to joke list ---
        header('location: jokes.php');
        exit;

    } catch (PDOException $e) {
        $title = 'An error has occurred';
        $output = 'Database error: ' . $e->getMessage();
    } catch (Exception $e) {
        $title = 'An error has occurred';
        $output = 'Error: ' . $e->getMessage();
    }
} else {
    // Display form
    $title = 'Add a New Joke';
    ob_start();
    include 'templates/addjoke.html.php';
    $output = ob_get_clean();
}

include 'templates/layout.html.php';
?>
