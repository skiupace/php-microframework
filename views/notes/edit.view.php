<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/navbar.php'); ?>
<?php require base_path('views/partials/banner.php'); ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 md:grid place-items-center">
    <div class="md:grid w-[50%] mt-10">
      <form method="POST" action="/note">
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="id" value="<?= $note['id']; ?>">

        <div class="shadow sm:overflow-hidden sm:rounded-md">
          <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-2">
              <label for="body" class="block text-sm/6 font-medium text-gray-900">Note</label>
              <div>
                <textarea
                  id="body"
                  name="body"
                  rows="5"
                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                  placeholder="Here's an idea for a note..."><?= $note['body']; ?></textarea>

                <?php if (isset($errors['body'])): ?>
                  <p class="text-red-500 text-xs mt-2"><?= $errors['body']; ?></p>
                <?php endif; ?>
              </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-3">
              <a href="/notes" name="discard" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Discard</a>
              <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</main>

<?php require base_path('views/partials/footer.php'); ?>