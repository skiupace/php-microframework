<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/navbar.php'); ?>
<?php require base_path('views/partials/banner.php'); ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <p class="text-lg mb-4">
      <a href="/notes" class="text-blue-400 underline">Go back</a>
    </p>
    <p class="text-lg"><?= htmlspecialchars($note['body']); ?></p>

    <footer class="mt-6 flex items-center justify-start gap-x-2">
      <form method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= $note['id']; ?>">
        <button class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Delete</button>
      </form>

      <a
        href="/note/edit?id=<?= $note['id']; ?>"
        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        Edit Note
      </a>
    </footer>
  </div>
</main>

<?php require base_path('views/partials/footer.php'); ?>