<?php

namespace App\Controller\Web;

use Awurth\Slim\Helper\Controller\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class SuratMasukController extends Controller
{
    public function index(Request $request, Response $response)
    {
        return $this->render($response, 'backend/surat-masuk.twig');
    }
}
