<?php

namespace App\Controllers;

use App\Models\User as User;
use App\Models\Menu as Menu;
use Respect\Validation\Validator as v;

class UserController extends Controller
{

        public function index($request, $response)
    {

        $data = [
            'users' => User::index(),
            'menu' => Menu::getMenu(),
            'subMenu' => Menu::getSubMenu(),
            'subMenuUsers' => Menu::getSubMenuUsers()

        ];

        return $this->view->render($response, 'users/users.twig', $data);
    }

    public function getUserAdd($request, $response)
    {
        $data = [
            'menu' => Menu::getMenu(),
            'subMenu' => Menu::getSubMenu(),
            'subMenuUsers' => Menu::getSubMenuUsers()
        ];

        return $this->view->render($response, 'users/add_edit.twig', $data);
    }


    public function postUserAdd($request, $response)
    {
        $validation = $this->validator->validate($request, [
            'email'     => v::noWhitespace()->notEmpty()->email(),
            'name'      => v::notEmpty()->alpha(),
            'login'     => v::notEmpty()->alpha(),
            'password'  => v::noWhitespace()->notEmpty(),

        ]);

        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('users.add'));
        }

        $user = User::UserAdd([
            'email'     => $request->getParam('email'),
            'name'      => $request->getParam('name'),
            'login'     => $request->getParam('login'),
            'blocked'   => $request->getParam('blocked'),
            'password'  => password_hash($request->getParam('password'), PASSWORD_DEFAULT)

        ]);

        return $response->withRedirect($this->router->pathFor('users'));

    }


}
