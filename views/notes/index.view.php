<?php require base_path('views/partials/head.php'); /* __DIR__ micro returns the current directory for the file */ ?>
<?php require base_path('views/partials/navbar.php'); ?>
<?php require base_path('views/partials/banner.php'); ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <ul>
      <?php foreach ($notes as $note): ?>
        <li>
          <a href="/note?id=<?= $note['id'] ?>" class="text-blue-600 hover:underline"><?= htmlspecialchars($note['body']); ?></a>
        </li>
      <?php endforeach; ?>
    </ul>

    <p class="mt-6">
      <a href="/notes/create" class="text-blue-600 hover:underline">Create Note</a>
    </p>
  </div>
</main>

<?php require base_path('views/partials/footer.php'); ?>