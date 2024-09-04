<?php

return function ($kirby, $page) {

  $error = false;
  $auth = false;
  $password = get('password');

  // handle the form submission
  if ($kirby->request()->is('POST')) {

    if (get('password')){
        if($password == $page->password()){
            $auth = true;
        }else{
            $error = "Password Incorrect";
        }
      // try to log the user in with the provided credentials
      try {
                
      } catch (Exception $e) {
        $code = $e;
      }
    }

  }

  return [
    'auth' => $auth,
    'password' => $password,
    'error' => $error,
  ];
};