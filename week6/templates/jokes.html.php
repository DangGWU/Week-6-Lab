<?php foreach ($jokes as $joke): ?>
  <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 15px; display: flex; align-items: flex-start; gap: 15px; border-radius: 8px; background: #fafafa;">
    
    <?php if (!empty($joke['jokeimage'])): ?>
      <img src="<?=htmlspecialchars($joke['jokeimage'], ENT_QUOTES, 'UTF-8')?>" 
           alt="Joke image"
           style="max-width: 150px; border-radius: 8px; object-fit: cover;">
    <?php endif; ?>

    <div style="flex: 1;">
      <blockquote style="margin: 0; font-style: italic; color: #333;">
        <?=nl2br(htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8'))?>
      </blockquote>

      <small style="color: gray; display: block; margin-top: 5px;">
        (by 
        <a href="mailto:<?=htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8')?>"> 
          <?=htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8')?> 
        </a>) — 
        Last updated on: <?=htmlspecialchars($joke['jokedate'], ENT_QUOTES, 'UTF-8')?>
      </small>

      <div style="margin-top: 8px; display: flex; gap: 8px;">
        <form action="editjoke.php" method="get" style="margin: 0;">
          <input type="hidden" name="id" value="<?=$joke['ID']?>">
          <input type="submit" value="Edit" style="background: #2196F3; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
        </form>

        <form action="deletejoke.php" method="post" style="margin: 0;">
          <input type="hidden" name="id" value="<?=$joke['ID']?>">
          <input type="submit" value="Delete" style="background: #f44336; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>
