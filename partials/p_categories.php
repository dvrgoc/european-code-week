<hr>
<?php

$single_category = false;
$update_status = false;

if (isset($_POST) && !empty($_POST['action'])) {
	$update_status = processCategoryData($_POST);
}

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
	$single_category = true;

	$category = getCategoryById($_GET['id']);
}

$categories =getCategoryChildren(0); ?>

<main class="col-sm-8">
	<section>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<?php if (!$single_category): ?>
				<li role="presentation" class="active"><a href="#list" aria-controls="list" role="tab" data-toggle="tab">List All Categories</a></li>
				<li role="presentation"><a href="#new" aria-controls="new" role="tab" data-toggle="tab">New Category</a></li>
			<?php else: ?>
				<li role="presentation" class="active"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit Category</a></li>
				<li role="presentation"><a href="#delete" aria-controls="delete" role="tab" data-toggle="tab">Delete Category</a></li>
			<?php endif ?>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<?php if (!$single_category): ?>
				<div role="tabpanel" class="tab-pane active" id="list">
					<?php if ($update_status): ?>
						<?php echo $update_status; ?>
					<?php endif ?>
					<?php showCategoryChildren($categories); ?>
				</div>
				<div role="tabpanel" class="tab-pane" id="new">
					<?php getCategoryDataForm(null, $categories);?>
				</div>
			<?php else: ?>
				<div role="tabpanel" class="tab-pane active" id="edit">
					<?php if ($update_status): ?>
						<?php echo $update_status; ?>
					<?php endif ?>
					<?php getCategoryDataForm($category, $categories);?>
				</div>
				<div role="tabpanel" class="tab-pane" id="delete">
					<?php getCategoryDeleteForm($category) ?>
				</div>
			<?php endif ?>
		</div>

		<?php if ($single_category): ?>
			<a href="<?php echo "//".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'] ?>" type="button" class="btn btn-default">Go Back</a>
		<?php endif ?>
	</section>
</main>

