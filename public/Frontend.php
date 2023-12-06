<?php
//Frontend class:
/**
 * HTML Document
 */
 
class Frontend {
    private $user;
    
    function __construct() {
        require_once 'User.php';
        $this->user = new User();
    }
    
    public function header() {
        $ver = 1;
        
        $return = '<head>';
            $return.= '<title>Hömérséklet Regiszter Rendszer</title>';
            $return.= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            $return.= '<link href="public/style/main.css?v=' . $ver . '" rel="stylesheet" type="text/css" />';
            $return.= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">';
            $return.= '<script src="https://code.jquery.com/jquery-3.6.0.js"></script>';
            $return.= '<script src="public/js/JScript.js?v=' . $ver . '"></script>';
        $return.= '</head>';
        
        return $return;
    }

    public function login_content() {

        //TODO
        if(count($_POST) > 0) {
            $errors = User::check_instance()->login($_POST);
    
            if(empty($errors['email_error']) && empty($errors['password_error']) && empty($errors['invalid_data'])) {
                header('Location: index.php');
                die;
            }
        }

        $return =
            '<div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card mt-5">
                            <div class="card-header">
                                Login
                            </div>

                            <div class="card-body">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="email" name="email" value="">
                                        
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

        return $return;
    }
    
    public function DOM(){
        $output = '';

        $output.= $this->header();
        if(isset($_POST['email']) && isset($_POST['password'])) {
            $output.= $this->login_content();   
        }

        return $output;
    }
}