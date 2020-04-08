<?php

namespace Projet\model;

require 'vendor/autoload.php';

use Projet\model\Manager;

class AccountManager extends Manager {

	function controlSignUp($pseudo, $email) 
	{
        $db      = $this->dbConnect();
        $request = $db->prepare('SELECT pseudo, email FROM members WHERE pseudo =? OR email =?');
        $request-> execute(array($pseudo, $email));
            
        return $request;
    }

	function loginMember($pseudo)
    {
        $db      = $this->dbConnect();
        $request = $db->prepare('SELECT id, pseudo, password, role FROM members WHERE pseudo = ?');
        $request->execute(array($pseudo));
        $logMember = $request->fetch();

        return $logMember;
    }

    function checkPseudo($pseudo)
    {
        $db      = $this->dbConnect();
        $request = $db->prepare('SELECT * FROM members WHERE pseudo = :pseudo');
        $request->execute(array('pseudo' => $pseudo));
        $pseudoChecked = $request->fetch();

        return $pseudoChecked;
    }

    function checkMail($email) {
        $db      = $this->dbconnect();
        $request = $db->prepare('SELECT email FROM members WHERE email = ?');
        $request->execute(array('email')); 
        $emailChecked = $request->fetch();

        return $emailChecked;
    } 

	function createMember($pseudo, $email, $password) 
	{
        $db = $this->dbConnect();
        $newMember = $db->prepare('INSERT INTO members (pseudo, email, avatar, password, role, date_create_account) VALUES (?, ?, ?, ?, 0, NOW())');
        $newMember -> execute(array($pseudo, $email, "default.PNG", $password));
            
        return $newMember;           
    }

    function updateProfile()
    {
        $db = $this->dbConnect();
        $updateProfile = $db->prepare('UPDATE members SET avatar = :avatar  WHERE id = :id');
        $updatedProfile = $updateProfile->execute(array(
            'avatar' => $_SESSION['id']));
        
        return $updatedProfile;
    }

    function getMembers() 
    {
        $db = $this->dbConnect();
        $members = $db->query('SELECT id, pseudo, email, role, date_create_account FROM members ORDER BY id');

        return $members;
    }


    public function inTable()
    {
        $db     = $this->dbconnect();
        $query  = $db->query('SELECT COUNT(flagged) FROM comments');
        $nombre = $query->fetch();
        
        return $nombre;
    }


}