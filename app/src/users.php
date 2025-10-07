<?php
    require 'config/db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        //Register
        if (isset($_POST['register'])) {            
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            
            $hasUppercase = preg_match('@[A-Z]@', $password);
            $hasLowercase = preg_match('@[a-z]@', $password);
            $hasNumber    = preg_match('@[0-9]@', $password);
            
            //Checks if the password has a upperace , a lowercase, a number and if its more than 6 symbols
            if(!$hasUppercase || !$hasLowercase || !$hasNumber || strlen($password) < 6) {
                echo "Password must be at least 6 characters, include at least 1 uppercased letter, at least 1 lowercased letter , and at least 1 number.";
            }else{

                //hashes the passowrd and insterts the values in the DB
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                $insertNewUser = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
                
                try {
                    $insertNewUser->execute([$name, $email, $hashedPassword, $role]);
                    echo "Registration successful!";
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
        } 
        //Log In        
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            //Finds the user by their email in the DB and checks if the passowrd matches
            $FindUserByEmail = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $FindUserByEmail->execute([$email]);
            $user = $FindUserByEmail->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                echo "Login successful! Welcome, " . htmlspecialchars($user['name']);
            } else {
                echo "Invalid email or password.";
            }
        }
    }
    
?>

