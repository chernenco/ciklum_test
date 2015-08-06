<?
session_start();
class DB{
	public function connect(){
		mysql_connect('localhost', 'root',  '')or die("cannot connect");
		mysql_select_db('ciklum_test')or die("cannot select DB");
    }
	public function query($sql){
		$this->connect();
        if($query=mysql_query($sql)){
			while($res=mysql_fetch_assoc($query)){
				$result[]=$res;
			}
			return $result;
	    }else{
			return false;
		}
	}
}
class User extends DB{
	public function Auth($set_login, $set_pass){
		$this->connect();
		if($result=$this->query('SELECT * FROM users WHERE login="'.$set_login.'" AND pass="'.$set_pass.'"')){
			$_SESSION['user']['id']=$result[0]['id'];
			$_SESSION['user']['login']=$result[0]['login'];
			return true;
		}else{
			return false;
		}
	}
	public function logout(){
		unset($_SESSION['user']);
		return true;
	}
	public function getUserId(){
		return $_SESSION['user']['id'];
	}
}
class product extends User{
	public function AddToBasket($product){
		$this->connect();
		if($query=mysql_query("INSERT INTO baskets (id_product, id_user) VALUES ('".$product."', '".$this->getUserId()."')")){
			return true;
		}else{
			return 'Error add to basket product - '.$product;
		}
	}
	public function RemoveFromBasket($product){
		$this->connect();
		if($result=$this->query('DELETE FROM baskets WHERE id_user="'.$this->getUserId().'" AND id_product="'.$product.'"')){
			return true;
		}else{
			return false;
		}
	}
	public function CreateOrder(){
		$this->connect();
		if($result=$this->query('SELECT * FROM baskets WHERE id_user="'.$this->getUserId().'"')){
			if($query=mysql_query("INSERT INTO orders (id_basket, id_user) VALUES ('".$result[0]['id']."', '".$this->getUserId()."')")){
				return true;
			}else{
				return 'Error create order';
			}
		}else{
			return 'Error create order';
		}
	}
	public function getImage($product){
		$this->connect();
		if($result=$this->query('SELECT * FROM images WHERE id_product="'.$product.'"')){
			return $result;
		}else{
			return false;
		}
	}
	public function getBasketUser(){
		$this->connect();
		if($result=$this->query('SELECT * FROM baskets WHERE id_user="'.$this->getUserId().'"')){
			return $result;
		}
	}
	public function getProducts(){
		$this->connect();
		if($result=$this->query('SELECT * FROM baskets ,products WHERE baskets.id_user="'.$this->getUserId().'" AND baskets.id_product=products.id')){
			return array_unique($result);
		}else{
			return false;
		}
		
	}
}
?>