<?php

namespace Cloudstorage\App\Controllers;

use Cloudstorage\App\Models\User;
use Cloudstorage\Core\Request;
use Cloudstorage\Core\Response;

class AuthController
{
    public function showLogin()
    {
        return view('Login@Auth');
    }

    public function login(Request $request, Response $response)
    {
        $userModel = new User();
        $user = $userModel->findByEmail($request->input('email'));

        if ($user && password_verify($request->input('password'), $user["password"])) {
            $_SESSION['user'] = $user["id"];
            return $response->redirect('/dashboard');
        }

        return view('Login@Auth', ['error' => 'Invalid credentials']);
    }

    public function showRegister()
    {
        return view('Register@Auth');
    }

    public function register(Request $request, Response $response)
    {
        $userModel = new User();
        $user = $userModel->findByEmail($request->input('email'));

        if ($user) {
            return view('Register@Auth', ['error' => 'Email already in use']);
        }

        $userModel->create([
            'email' => $request->input('email'),
            'password' => password_hash($request->input('password'), PASSWORD_DEFAULT)
        ]);

        return $response->redirect('/auth/login');
    }

    public function showForgotPassword()
    {
        return view('ForgotPassword@Auth');
    }

    public function forgotPassword(Request $request, Response $response)
    {
        if ($request->input('email') !== null) {
            $userModel = new User();
            $user = $userModel->findByEmail($request->input('email'));

            if ($user !== null) {
                if (sendMail($request->input('email'), "Wachtwoord Resetten | Cloudstorage", "welcome", ["user" => $user])) {
                    return view('Login@Auth');
                } else {
                    return view('ForgotPassword@Auth', ['error' => 'Er is iets fout gegaan, probeer het later opnieuw.']);
                }
            } else {
                return view('Login@Auth');
            }
        } else {
            return view('ForgotPassword@Auth', ['error' => 'Vul een geldig e-mailadres in']);
        }
    }

    public function logout(Response $response)
    {
        unset($_SESSION['user']);
        return $response->redirect('/auth/login');
    }
}
