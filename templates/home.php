<main class="container">
    <form>
        <div class="form-group">
            <label for="size">Page size</label>
            <select id="size" name="size">
                <?php foreach ($possiblePageSizes as $pageSize): ?>
                <option <?php if ($pageSize == $size): ?>selected="selected"<?php endif ?>><?= $pageSize ?></option>
                <?php endforeach ?>
            </select>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <?php require "pagination.php"; ?>
    <?php foreach ($content as $picture): ?>
        <a href="/image/<?php esc($picture->getId()) ?>"><img title="<?php esc($picture->getTitle()) ?>" src="<?php esc($picture->getThumbnail()) ?>" /></a>
    <?php endforeach; ?>
    <?php require "pagination.php"; ?>
</main>