<?php

$single_product = false;
$update_status = false;

if (isset($_POST) && !empty($_POST['action'])) {
	$update_status = processProductData($conn, $_POST);
}

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
	$single_product = true;

	$product = getProductById($conn, $_GET['id']);
}
?>

<main class="col-sm-8">
	<section>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<?php if (!$single_product): ?>
			<li role="presentation" class="active"><a href="#list" aria-controls="list" role="tab" data-toggle="tab">List All Products</a></li>
			<li role="presentation"><a href="#new" aria-controls="new" role="tab" data-toggle="tab">New Product</a></li>
			<?php else: ?>
			<li role="presentation" class="active"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit Prouduct</a></li>
			<li role="presentation"><a href="#delete" aria-controls="delete" role="tab" data-toggle="tab">Delete Product</a></li>
			<?php endif ?>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<?php if (!$single_product): ?>
			<div role="tabpanel" class="tab-pane active" id="list">
				<?php if ($update_status): ?>
					<?php echo $update_status; ?>
				<?php endif ?>
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
			<div role="tabpanel" class="tab-pane" id="new">
				<?php getProductDataForm();?>
			</div>
			<?php else: ?>
			<div role="tabpanel" class="tab-pane active" id="edit">
				<?php if ($update_status): ?>
					<?php echo $update_status; ?>
				<?php endif ?>
				<?php getProductDataForm($product);?>
			</div>
			<div role="tabpanel" class="tab-pane" id="delete">
				<?php getProductDeleteForm($product) ?>
			</div>
			<?php endif ?>
		</div>

		<?php if ($single_product): ?>
			<a href="<?php echo "//".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'] ?>" type="button" class="btn btn-default">Go Back</a>
		<?php endif ?>
	</section>
</main>

