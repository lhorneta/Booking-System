<?php if (count($messages)): ?>
    <?php foreach ($messages as $message): ?>
        <div class="error-message"><p><?= $message; ?></p></div>
    <?php endforeach; ?>
<?php endif; ?>
