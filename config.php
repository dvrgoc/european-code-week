<?php
//@TODO: create readme file
//@TODO: refactor mysql connection variable - make $cnnct global in all product functions
//@TODO: that is - remove it as an function argument
$config = array(
	'default_timezone' => 'Europe/Zagreb'
);


date_default_timezone_set($config['default_timezone']);


function connect2db($credentials) {
	$connection = mysqli_connect(
		$credentials['mysql']['host'],
		$credentials['mysql']['username'],
		$credentials['mysql']['password'],
		$credentials['mysql']['db']
	);

	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	mysqli_select_db($connection, $credentials['mysql']['db']);

	return $connection;
}

$cnnct = connect2db($credentials);

function disconnectFromDb($connection) {
	mysqli_close($connection);
}

function getAllProducts($connection) {
	$results = $connection->query('SELECT id, title FROM products ORDER BY title ASC ');

	if($results->num_rows) {
		/*var_dump("true");*/
		return mysqli_fetch_all($results, MYSQLI_ASSOC);
	}

	return false;
}

function getProductById($connection, $id) {
	$result = $connection->query('SELECT * FROM products where id = '.$id);

	if($result->num_rows) {
		/*var_dump("true");*/
		return $result->fetch_assoc();
	}

	return false;
}

function getProductDataForm($product = null){
	?>
	<form action="/products.php<?php echo $product ? '?id='.$product['id'] : ''  ?>" method="post">
		<input type="hidden" name="id" id="id" value="<?php echo $product ? $product['id'] : "" ?>" />
		<input type="hidden" name="action" id="action" value="<?php echo $product ? "update" : "create" ?>" />

		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" name="title" id="title" value="<?php echo $product ? $product['title'] : '' ?>" class="form-control" />
		</div>

		<div class="form-group">
			<label for="short_description">Short description</label>
			<input type="text" name="short_description" id="short_description" value="<?php echo $product ? $product['short_description'] : '' ?>" class="form-control" />
		</div>

		<div class="form-group">
			<label for="price">Price</label>
			<input type="text" name="price" id="price" value="<?php echo $product ? $product['price'] : null ?>" class="form-control" />
		</div>

		<div class="form-group">
			<label for="promo_price">Promo price</label>
			<input type="text" name="promo_price" id="promo_price" value="<?php echo $product ? $product['promo_price'] : null ?>" class="form-control" />
		</div>

		<button type="submit" class="btn btn-primary">
			<?php echo $product ? "Update product" : "Save product" ?>
		</button>
	</form>
	<?php
	return false;
}

function getProductDeleteForm($product){
	?>
	<form action="/products.php" method="post">
		<input type="hidden" name="id" id="id" value="<?php ECHO $product['id'] ?>" />
		<input type="hidden" name="action" id="action" value="delete" />

		<p>Are you sure you want to delete this product? This cannot be undone</p>
		<button type="submit" class="btn btn-primary">Delete Product</button>
	</form>
	<?php
}

function processProductData($connection, $data) {
	if ($data['action'] === "create") {
		$result = $connection->query(
			'INSERT INTO products (title, short_description, price, promo_price) VALUES
				("'.$data["title"].'",
				"'.$data["short_description"].'",
				"'.$data["price"].'",
				'.(((float)($data["promo_price"]) > 0) ?
				$data["promo_price"] :
				"NULL").'
		        );'
		);

		if ($result) {
			return '<p class="bg-success">Product created successfully</p>';
		} else {
			return '<p class="bg-danger">Error creating product: '.$connection->error.'</p>';
		}
	}

	if ($data['action'] === "update") {
		$result = $connection->query(
			'UPDATE products set 
				title="'.$data["title"].'",
				short_description="'.$data["short_description"].'",
				price="'.$data["price"].'",
				promo_price='.
					(((float)($data["promo_price"]) > 0) ?
						$data["promo_price"] :
						"NULL").'
				WHERE id='.$data["id"]
		);

		if ($result) {
			return '<p class="bg-success">Product updated successfully</p>';
		} else {
			return '<p class="bg-danger">Error updating product: '.$connection->error.'</p>';
		}
	}

	if ($data['action'] === "delete") {
		$result = $connection->query('DELETE FROM products WHERE id='.$data['id']);

		if ($result) {
			return '<p class="bg-success">Product deleted successfully</p>';
		} else {
			return '<p class="bg-danger">Error deleting product: '.$connection->error.'</p>';
		}
	}
}

/* categories functions */
function getAllCategories() {
	global $cnnct;
	$results = $cnnct->query('SELECT id, title FROM categories ORDER BY title ASC ');

	if($results->num_rows) {
		/*var_dump("true");*/
		return mysqli_fetch_all($results, MYSQLI_ASSOC);
	}

	return false;
}

function getCategoryById($id) {
	global $cnnct;
	$result = $cnnct->query('SELECT * FROM categories where id = '.$id);

	if($result->num_rows) {
		/*var_dump("true");*/
		return $result->fetch_assoc();
	}

	return false;
}

function getCategoryDataForm($category = null, $categories = null){
	?>
	<form action="/categories.php<?php echo $category ? '?id='.$category['id'] : ''  ?>" method="post">
		<input type="hidden" name="id" id="id" value="<?php echo $category ? $category['id'] : "" ?>" />
		<input type="hidden" name="action" id="action" value="<?php echo $category ? "update" : "create" ?>" />

		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" name="title" id="title" value="<?php echo $category ? $category['title'] : '' ?>" class="form-control" />
		</div>

		<div class="form-group">
			<label for="short_description">Short description</label>
			<input type="text" name="short_description" id="short_description" value="<?php echo $category ? $category['short_description'] : '' ?>" class="form-control" />
		</div>

		<div class="form-group">
			<label for="price">Parent category</label>
			<select class="form-control" name="parent_cat_id" id="parent_cat_id">
				<?php
				if ($category['parent_cat_id']):
					?>
					<option value="0">No parent category</option>
					<?php
				foreach ($categories as $category_item): ?>
					<option value="<?php echo $category_item['id'] ?>"
						<?php if ($category['id'] === $category_item['id']):?>
						selected="selected"
						<?php $parent_cat = getCategoryById($category['parent_cat_id']) ?>
						><?php echo $parent_cat['title'] ?>

						<?php else: ?>
							><?php echo $category_item['title'] ?>
						<?php endif ?>
					</option>
				<?php
				endforeach;
				else:
					?>
					<option value="0" selected="selected">No parent category</option>
					<?php
					foreach ($categories as $category_item): ?>
						<option value="<?php echo $category_item['id'] ?>"><?php echo $category_item['title'] ?></option>
						<?php
					endforeach;
					endif;
					?>
			</select>
		</div>

		<button type="submit" class="btn btn-primary">
			<?php echo $category ? "Update category" : "Save category" ?>
		</button>
	</form>
	<?php
	return false;
}

function processCategoryData($data) {
	global $cnnct;
	if ($data['action'] === "create") {
		$result = $cnnct->query(
			'INSERT INTO categories (title, short_description, parent_cat_id) VALUES
				("'.$data["title"].'",
				"'.$data["short_description"].'",
				"'.$data["parent_cat_id"].'"
		        );'
		);

		if ($result) {
			return '<p class="bg-success">Category created successfully</p>';
		} else {
			return '<p class="bg-danger">Error creating category: '.$cnnct->error.'</p>';
		}
	}

	if ($data['action'] === "update") {
			$result = $cnnct->query(
				'UPDATE categories set
					title="'.$data["title"].'",
					short_description="'.$data["short_description"].'",
					parent_cat_id='.$data["parent_cat_id"].'
					WHERE id='.$data["id"]
			);

			if ($result) {
				return '<p class="bg-success">Category updated successfully</p>';
			} else {
				return '<p class="bg-danger">Error updating category: '.$cnnct->error.'</p>';
			}
		}

	if ($data['action'] === "delete") {
		$result = $cnnct->query('DELETE FROM categories WHERE id='.$data['id']);

		if ($result) {
			return '<p class="bg-success">Category deleted successfully</p>';
		} else {
			return '<p class="bg-danger">Error deleting category: '.$cnnct->error.'</p>';
		}
	}

	unset($_POST);
	var_dump($_POST);
}

function getCategoryDeleteForm($category){
	?>
	<form action="/categories.php" method="post">
		<input type="hidden" name="id" id="id" value="<?php echo $category['id'] ?>" />
		<input type="hidden" name="action" id="action" value="delete" />

		<p>Are you sure you want to delete this category? This cannot be undone</p>
		<button type="submit" class="btn btn-primary">Delete Category</button>
	</form>
	<?php
}




