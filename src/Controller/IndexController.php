<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
class IndexController extends AbstractController
{
 public function home()
 {
    $articles=['Article1', 'Article 2', 'Article 3'];

 return $this->render('articles/index.html.twig',['articles' => $articles]);
 
 }
}
