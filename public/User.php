<?php
//User class:
/**
 * Login Action
 * CSRF Token
 * Admin Check Action
 * Users CRUD Actions
 */

 class User {
    private $db;

    function __construct() {
        require_once 'Database.php';
        $this->db = new Database();
    }

    public function select() {
        $params = array('id', 'email', 'chamber_id', 'role');
        /*$where = array(
            'email' => 'szadaegyetem@gmail.com'
        );*/
        $result = $this->db->querySelect($params, 'users'/*, $where */);

        if(empty($result)) {
            die('<br>A SELECT lekérés során valamilyen hiba történt! [Üres tömb]');
        }
        
        return $result;
    }

    /**
     * Test 0.1
     */
    public function login($POST) {
        //Inicializáció
        $errors = array(
            'email_error' => '',
            'password_error' => '',
            'invalid_data' => ''
        );
        $params = array('id', 'email', 'chamber_id', 'role');
        
        //$POST[] Adatok és SQL lekérdezés
        $array['email'] = trim(addslashes($POST['email']));
        $password = trim(addslashes($POST['password']));
        
        $where = array(
            'email' => $array['email']
        );

        $data = $this->db->querySelect($params, 'users', $where);

        //Regex E-mail-re és jelszóra
        $email_regex = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/i';
        $password_regex = '/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@#^&_+-])[a-zA-Z0-9@#^&_+-]{8,12}$/';

        //Validáció
        if(empty($a['email']) || !preg_match($email_regex, $a['email'])) {
            $errors['email_error'] = 'Kérem a megfelelő e-mail formátumot használja (pelda@email.hu)';
        }

        if(empty($a['password']) || !preg_match($password_regex, $a['password'])) {
            $errors['password_error'] = 'Kérem a megfelelő formátumot használja!';
        }
        
        if(is_array($data)) {
            $data = $data[0];

            if(password_verify($password, $data->password)) {
                //$session = new Session();
                //$session->regenerate();

                $array['user_id'] = $data->id;
                $array['email'] = $data->email;
                $array['chamber_id'] = $data->chamber_id; 
                $array['role'] = $data->role;

                //$session->set('USER', $a);

                echo '<var>';
                var_dump($array);
                return true;
            }
        } 

        $errors['invalid_data'] = 'Nem megfelelő jelszó vagy e-mail cím!';

        return $errors;
    }
 }