<form action="addjoke.php" method="post" enctype="multipart/form-data" style="max-width: 600px; margin: 0 auto;">
  <h2>Add a New Joke</h2>

  <label for="name">Your Name:</label><br>
  <input type="text" id="name" name="name" required style="width:100%; padding:8px;"><br><br>

  <label for="email">Your Email:</label><br>
  <input type="email" id="email" name="email" required style="width:100%; padding:8px;"><br><br>

  <label for="joketext">Enter Your Joke:</label><br>
  <textarea id="joketext" name="joketext" rows="5" required style="width:100%; padding:8px;"></textarea><br><br>

  <label for="jokeimage">Upload an Image (optional):</label><br>
  <input type="file" name="jokeimage" id="jokeimage" accept="image/*" style="padding:8px;"><br><br>

  <input type="submit" value="Add Joke" 
         style="background-color:#4CAF50; color:white; border:none; padding:10px 20px; cursor:pointer; border-radius:5px;">
</form>
