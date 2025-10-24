<form action="editjoke.php" method="post" enctype="multipart/form-data" style="max-width: 600px; margin: 0 auto;">
  <h2>Edit Joke</h2>

  <input type="hidden" name="id" value="<?=htmlspecialchars($joke['ID'], ENT_QUOTES, 'UTF-8')?>">
  <input type="hidden" name="existing_image" value="<?=htmlspecialchars($joke['jokeimage'], ENT_QUOTES, 'UTF-8')?>">

  <label for="name">Author Name:</label><br>
  <input type="text" id="name" name="name" 
         value="<?=htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8')?>" 
         required style="width:100%; padding:8px;"><br><br>

  <label for="email">Author Email:</label><br>
  <input type="email" id="email" name="email" 
         value="<?=htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8')?>" 
         required style="width:100%; padding:8px;"><br><br>

  <label for="joketext">Joke Text:</label><br>
  <textarea id="joketext" name="joketext" rows="5" required 
            style="width:100%; padding:8px;"><?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8')?></textarea><br><br>

  <?php if (!empty($joke['jokeimage'])): ?>
    <label>Current Image:</label><br>
    <img src="<?=htmlspecialchars($joke['jokeimage'], ENT_QUOTES, 'UTF-8')?>" 
         alt="Current joke image" style="max-width:200px; border-radius:8px; margin-bottom:10px;"><br>
  <?php endif; ?>

  <label for="jokeimage">Upload New Image (optional):</label><br>
  <input type="file" name="jokeimage" id="jokeimage" accept="image/*" style="padding:8px;"><br><br>

  <input type="submit" value="Update Joke" 
         style="background-color:#4CAF50; color:white; border:none; padding:10px 20px; cursor:pointer; border-radius:5px;">
</form>
