<?php
$single_product = false;
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
	$single_product = true;
}
?>

<main class="col-sm-8">
	<section>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<?php if (!$single_product): ?>
			<li role="presentation" class="active"><a href="#list" aria-controls="list" role="tab" data-toggle="tab">List</a></li>
			<li role="presentation"><a href="#new" aria-controls="new" role="tab" data-toggle="tab">New</a></li>
			<?php else: ?>
			<li role="presentation" class="active"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit</a></li>
			<li role="presentation"><a href="#delete" aria-controls="delete" role="tab" data-toggle="tab">Delete</a></li>
			<?php endif ?>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<?php if (!$single_product): ?>
			<div role="tabpanel" class="tab-pane active" id="list">
				<?php
				$products = getAllProducts($conn);
				if ($products): ?>
					<ul>
						<?php foreach ($products as $product): ?>
							<li>
								<a href="?id=<?php echo $product['id'] ?>"><?php echo $product['title'] ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php else: ?>
					<p>No products found.</p>
				<?php endif; ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="new">2</div>
			<?php else: ?>
			<div role="tabpanel" class="tab-pane active" id="edit">
				<?php echo $_GET['id'] ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="delete">4</div>
			<?php endif ?>
		</div>

		<?php if ($single_product): ?>
			<a href="<?php echo "//".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'] ?>" type="button" class="btn btn-default">Go Back</a>
		<?php endif ?>
	</section>
</main>

