<?php
//@TODO: create readme file
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

function getProductForm($product = null){
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

function processProductData($connection, $data) {
	if ($data['action'] === "create") {
		$result = $connection->query(
			'INSERT INTO products (title, short_description, price, promo_price) VALUES
				("'.$data["title"].'",
				"'.$data["short_description"].'",
				"'.$data["price"].'",
				'.(((float)($data["promo_price"]) > 0) ?
					$data["promo_price"] :
					"NULL")
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
}