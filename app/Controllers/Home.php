<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;

class Home extends BaseController
{
	private $userModel=NULL;
	private $googleClient=NULL;
	function __construct(){
		require_once APPPATH. "libraries/vendor/autoload.php";
		$this->userModel = new UserModel();
		$this->googleClient = new \Google_Client();
		$this->googleClient->setClientId("Put Your Client Id");
		$this->googleClient->setClientSecret("Put Your Secret Id");
		$this->googleClient->setRedirectUri("Put Your Redirect Uri");
		$this->googleClient->addScope("email");
		$this->googleClient->addScope("profile");

	}
	public function index()
	{
		if(session()->get("LoggedUserData")){
			session()->setFlashData("Error", "You have Already Logged In");
			return redirect()->to(base_url()."/profile");
		}
		$data['googleButton'] = '<a href="'.$this->googleClient->createAuthUrl().'" ><img src="public/uploads/google.png" alt="Login With Google" width="100%"></a>';
		return view('login', $data);
	}
	public function profile()
	{
		if(!session()->get("LoggedUserData")){
			session()->setFlashData("Error", "You have Logged Out, Please Login Again.");
			return redirect()->to(base_url());
		}
		return view('profile');
	}
	public function loginWithGoogle()
	{
		$token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
		if(!isset($token['error'])){
			$this->googleClient->setAccessToken($token['access_token']);
			session()->set("AccessToken", $token['access_token']);

			$googleService = new \Google_Service_Oauth2($this->googleClient);
			$data = $googleService->userinfo->get();
			$currentDateTime = date("Y-m-d H:i:s");
			//echo "<pre>"; print_r($data);die;
			$userdata=array();
			if($this->userModel->isAlreadyRegister($data['id'])){
				//User ALready Login and want to Login Again
				$userdata = [
					'name'=>$data['givenName']. " ".$data['familyName'], 
					'email'=>$data['email'] , 
					'profile_img'=>$data['picture'], 
					'updated_at'=>$currentDateTime
				];
				$this->userModel->updateUserData($userdata, $data['id']);
			}else{
				//new User want to Login
				$userdata = [
					'oauth_id'=>$data['id'],
					'name'=>$data['givenName']. " ".$data['familyName'], 
					'email'=>$data['email'] , 
					'profile_img'=>$data['picture'], 
					'created_at'=>$currentDateTime
				];
				$this->userModel->insertUserData($userdata);
			}
			session()->set("LoggedUserData", $userdata);

		}else{
			session()->setFlashData("Error", "Something went Wrong");
			return redirect()->to(base_url());
		}
		//Successfull Login
		return redirect()->to(base_url()."/profile");
	}

	function logout(){
		session()->remove('LoggedUserData');
		session()->remove('AccessToken');
		if(!(session()->get('LoggedUserData') && session()->get('AccessToken') )){
			session()->setFlashData("Success", "Logout Successful");
			return redirect()->to(base_url());
		}else{
			session()->setFlashData("Error", "Failed to Logout, Please Try Again");
			return redirect()->to(base_url()."/profile");
		}
	}
}