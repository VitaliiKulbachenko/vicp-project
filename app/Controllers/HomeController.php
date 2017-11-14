<?php

namespace App\Controllers;

use App\Models\Menu as Menu;

class HomeController extends Controller
{

    public function index($request, $response)
    {

        $data = [
            'menu' => Menu::getMenu(),
            'subMenu' => Menu::getSubMenu(),
        ];

        return $this->view->render($response, 'home.twig', $data);
    }



}