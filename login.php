<?php

session_start(); // ensure sessions are usable

class Login
{
    private $error = "";

    public function evaluate($data)
    {
        $email = htmlspecialchars(trim($data['email']));
        $password = htmlspecialchars(trim($data['password']));

        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";

        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            $row = $result[0];

            if ($this->hash_text($password) === $row['password']) {
                // login success
                $_SESSION['mybook_userid'] = $row['userid'];
            } else {
                $this->error = "Wrong email or password.";
            }
        } else {
            $this->error = "Wrong email or password.";
        }

        return $this->error;
    }

    private function hash_text($text)
    {
        return hash("sha1", $text); // OK for testing, NOT secure long-term
    }

    public function check_login($id, $redirect = true)
    {
        if (is_numeric($id)) {
            $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";

            $DB = new Database();
            $result = $DB->read($query);

            if ($result) {
                return $result[0]; // return user data
            }
        }

        if ($redirect) {
            header("Location: login.php");
            die;
        } else {
            $_SESSION['mybook_userid'] = 0;
            return false;
        }
    }
}
