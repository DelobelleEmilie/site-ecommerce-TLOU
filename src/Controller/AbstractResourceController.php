<?php

namespace App\Controller;

use App\Core\Router\Router;

abstract class AbstractResourceController extends AbstractController {

    abstract public function show($id);

    abstract public function showList();

    abstract public function delete($id);

    abstract public function edit($id = null);
}