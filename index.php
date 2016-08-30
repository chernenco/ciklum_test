<?include('lib.php');
$action = isset($_POST['action']) ? $_POST['action'] : '';
switch ($action) {
case 'authorization':
	$name = trim($_POST['name']);
	if($name==''){
		die(json_encode(array('result' => 'error', 'message' => 'Do not fill in the name')));
	}
	$password = trim($_POST['password']);
	if($password==''){
		die(json_encode(array('result' => 'error', 'message' => 'Do not fill in the password')));
	}
	$obj=new User;
	if($obj->Auth($name,$password)){
		die(json_encode(array('result' => 'ok')));
	}
break;
case 'logout':   
	$obj=new User;
	$result=$obj->logout();
	die(json_encode(array('result' => 'ok')));
break;
case 'AddToBasket':
	$product = trim($_POST['product']);
	if($product==''){
		die(json_encode(array('result' => 'error', 'message' => 'no products')));
	}
	$obj=new product;
	$result=$obj->AddToBasket();
	if($result===true){
		die(json_encode(array('result' => 'ok')));
	}else{	
		die(json_encode(array('result' => 'error', 'message' => $result)));
	}
break;
case 'RemoveFromBasket':
	$product = trim($_POST['product']);
	if($product==''){
		die(json_encode(array('result' => 'error', 'message' => 'no products')));
	}
	$obj=new product;
	$result=$obj->RemoveFromBasket();
	if($result===true){
		die(json_encode(array('result' => 'ok')));
	}else{	
		die(json_encode(array('result' => 'error', 'message' => 'error delete product from basket')));
	}
break;
case 'getImage':
	$product = trim($_POST['product']);
	if($product==''){
		die(json_encode(array('result' => 'error', 'message' => 'no products')));
	}
	$obj=new product;
	$result=$obj->getImage();
	if($result!==false){
		die(json_encode(array('result' => 'ok','data'=>$result)));
	}else{	
		die(json_encode(array('result' => 'error', 'message' => 'error get image')));
	}
break;
case 'CreateOrder':
	$obj=new product;
	$result=$obj->CreateOrder();
	if($result===true){
		die(json_encode(array('result' => 'ok')));
	}else{	
		die(json_encode(array('result' => 'error', 'message' => $result)));
	}
break;
case 'getBasketUser':
	$obj=new product;
	$result=$obj->getBasketUser();
	if($result!==false){
		die(json_encode(array('result' => 'ok','data'=>$result)));
	}else{	
		die(json_encode(array('result' => 'error', 'message' => 'error get basket user')));
	}
break;
case 'getProducts':
	$obj=new product;
	$result=$obj->getProducts();
	if($result!==false){
		die(json_encode(array('result' => 'ok','data'=>$result)));
	}else{	
		die(json_encode(array('result' => 'error', 'message' => 'error get products from basket user')));
	}
break;


}
?>