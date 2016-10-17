<?php

$config = array(
	'default_timezone' => 'Europe/Zagreb',
	'grid' => array(
		'sidebar'   => 'col-sm-3 col-md-2',
		'main'      => 'col-sm-9 col-md-10',
		'homepage'  => 'col-xs-12'
	)
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

function disconnectFromDb() {
	global $conn;
	mysqli_close($conn);
}

function getAllProducts() {
	global $conn;
	$results = $conn->query('SELECT id, title FROM products ORDER BY title ASC ');

	if($results->num_rows) {
		/*var_dump("true");*/
		return mysqli_fetch_all($results, MYSQLI_ASSOC);
	}

	return false;
}

function getProductById($id) {
	global $conn;
	$result = $conn->query('SELECT * FROM products where id = '.$id);

	if($result->num_rows) {
		/*var_dump("true");*/
		return $result->fetch_assoc();
	}

	return false;
}

function getProductDataForm($product = null){
	?>
	<form id="form-products-data" action="/products.php<?php echo $product ? '?id='.$product['id'] : ''  ?>" method="post">
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
	<form  id="form-products-delete" action="/products.php" method="post">
		<input type="hidden" name="id" id="id" value="<?php ECHO $product['id'] ?>" />
		<input type="hidden" name="action" id="action" value="delete" />

		<p>Are you sure you want to delete this product? This cannot be undone</p>
		<button type="submit" class="btn btn-primary">Delete Product</button>
	</form>
	<?php
}

function processProductData($data) {
	global $conn;
	if ($data['action'] === "create") {
		$result = $conn->query(
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
			return '<p class="bg-danger">Error creating product: '.$conn->error.'</p>';
		}
	}

	if ($data['action'] === "update") {
		$result = $conn->query(
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
			return '<p class="bg-danger">Error updating product: '.$conn->error.'</p>';
		}
	}

	if ($data['action'] === "delete") {
		$result = $conn->query('DELETE FROM products WHERE id='.$data['id']);

		if ($result) {
			return '<p class="bg-success">Product deleted successfully</p>';
		} else {
			return '<p class="bg-danger">Error deleting product: '.$conn->error.'</p>';
		}
	}
}

/* categories functions */
function getAllCategories() {
	global $conn;
	$results = $conn->query('SELECT id, title, parent_cat_id FROM categories ORDER BY title ASC');

	if($results->num_rows) {
		/*var_dump("true");*/
		return mysqli_fetch_all($results, MYSQLI_ASSOC);
	}

	return false;
}

function getCategoryTree($parent_category_id) {
	global $conn;

	$categories = $conn->query('SELECT id, title FROM categories WHERE parent_cat_id = '.$parent_category_id.' ORDER BY title ASC');

	$children = array();

	$rows = mysqli_fetch_all($categories, MYSQLI_ASSOC);

	if ($rows):
		foreach ($rows as $row) :

		array_push($children, array(
			"id" => $row['id'],
			"title" => $row['title'],
			"children" => getCategoryTree($row['id'])
		));

		endforeach;
	endif;

	return $children;
}

function showCategoryTree($items) {
	if ($items):
		echo '<ul>';
		foreach ($items as $item):
			echo '<li>';
			echo '<a href="//'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?id='.$item['id'].'">'.$item['title'].'</a>';
			if ($item['children']) {
				showCategoryTree($item['children']);
			}
			echo '</li>';
		endforeach;
		echo '</ul>';
	else:
		echo "<p>No categories found</p>";
	endif;
}


function getCategoryById($id) {
	global $conn;
	$result = $conn->query('SELECT * FROM categories where id = '.$id);

	if($result->num_rows) {
		/*var_dump("true");*/
		return $result->fetch_assoc();
	}

	return false;
}

function getCategoryDataForm($category = null, $categories = null){
	?>
	<form id="form-categories-data" action="/categories.php<?php echo $category ? '?id='.$category['id'] : ''  ?>" method="post">
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
						<?php if ($category['parent_cat_id'] === $category_item['id']):?>
						selected="selected">
						<?php $parent_cat = getCategoryById($category['parent_cat_id']) ?>
							<?php echo $parent_cat['title'] ?>
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
	global $conn;
	if ($data['action'] === "create") {
		$result = $conn->query(
			'INSERT INTO categories (title, short_description, parent_cat_id) VALUES
				("'.$data["title"].'",
				"'.$data["short_description"].'",
				"'.$data["parent_cat_id"].'"
		        );'
		);

		if ($result) {
			return '<p class="bg-success">Category created successfully</p>';
		} else {
			return '<p class="bg-danger">Error creating category: '.$conn->error.'</p>';
		}
	}

	if ($data['action'] === "update") {
			$result = $conn->query(
				'UPDATE categories set
					title="'.$data["title"].'",
					short_description="'.$data["short_description"].'",
					parent_cat_id='.$data["parent_cat_id"].'
					WHERE id='.$data["id"]
			);

			if ($result) {
				return '<p class="bg-success">Category updated successfully</p>';
			} else {
				return '<p class="bg-danger">Error updating category: '.$conn->error.'</p>';
			}
		}

	if ($data['action'] === "delete") {
		$result = $conn->query('DELETE FROM categories WHERE id='.$data['id']);

		if ($result) {
			return '<p class="bg-success">Category deleted successfully</p>';
		} else {
			return '<p class="bg-danger">Error deleting category: '.$conn->error.'</p>';
		}
	}

	unset($_POST);
}

function getCategoryDeleteForm($category){
	?>
	<form id="form-category-data" action="/categories.php" method="post">
		<input type="hidden" name="id" id="id" value="<?php echo $category['id'] ?>" />
		<input type="hidden" name="action" id="action" value="delete" />

		<p>Are you sure you want to delete this category? This cannot be undone</p>
		<button type="submit" class="btn btn-primary">Delete Category</button>
	</form>
	<?php
}




