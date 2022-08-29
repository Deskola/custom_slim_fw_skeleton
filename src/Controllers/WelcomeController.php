<?php

namespace App\Controllers;

use App\Models\User;

class WelcomeController
{
    public function delete($request, $response)
    {
        //$this->userRepository->remove($request->getAttribute('id'));
        $users = User::all();


        $response->getBody()->write(json_encode($users));
        return $response;
    }

    public function test($request, $response, $name)
    {
        $parsedBody = $request->getParsedBody();
        $user = new User();
        $user->setName($parsedBody['name']);
        $user->setAge($parsedBody['age']);
        $user->save();

        $response->getBody()->write('saved Successfuly');
        return $response->withStatus(200);
    }
}