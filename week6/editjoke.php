<?php
try {
    include 'includes/DatabaseConnection.php';

    // --- 1. Handle POST (form submission) ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $joketext = trim($_POST['joketext']);
        $imagePath = $_POST['existing_image'] ?? null;

        // --- 2. Handle image upload (optional) ---
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
                    // Delete old image if it exists
                    if (!empty($imagePath) && file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $imagePath = $destPath;
                } else {
                    throw new Exception('Error moving uploaded file.');
                }
            } else {
                throw new Exception('Invalid file type.');
            }
        }

        // --- 3. Update author ---
        $updateAuthor = 'UPDATE author 
                         SET name = :name, email = :email 
                         WHERE id = (SELECT authorid FROM jokes WHERE ID = :id)';
        $stmt = $pdo->prepare($updateAuthor);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        // --- 4. Update joke ---
        $updateJoke = 'UPDATE jokes 
                       SET joketext = :joketext,
                           jokeimage = :jokeimage,
                           jokedate = CURDATE()
                       WHERE ID = :id';
        $stmt = $pdo->prepare($updateJoke);
        $stmt->bindValue(':joketext', $joketext);
        $stmt->bindValue(':jokeimage', $imagePath);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        header('Location: jokes.php');
        exit;
    }

    // --- 5. Handle GET (display edit form) ---
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = 'SELECT jokes.ID, joketext, jokedate, jokeimage, author.name, author.email
                FROM jokes
                INNER JOIN author ON jokes.authorid = author.id
                WHERE jokes.ID = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $joke = $stmt->fetch();

        if (!$joke) {
            throw new Exception('Joke not found.');
        }

        $title = 'Edit Joke';
        ob_start();
        include 'templates/editjoke.html.php';
        $output = ob_get_clean();
    } else {
        throw new Exception('No joke ID specified.');
    }

} catch (PDOException $e) {
    $title = 'Database Error';
    $output = 'Error: ' . $e->getMessage();
} catch (Exception $e) {
    $title = 'Error';
    $output = 'Error: ' . $e->getMessage();
}

include 'templates/layout.html.php';
?>
