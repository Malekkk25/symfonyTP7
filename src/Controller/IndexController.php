<?php
namespace App\Controller;
use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\ArticleType;
use App\Entity\Category;
use App\Form\CategoryType;

class IndexController extends AbstractController
{
   private $entityManager;

   public function __construct(ManagerRegistry $entityManager)
   {
       $this->entityManager = $entityManager;
   }
   public function home()
 {
$articles= $this->entityManager->getRepository(Article::class)->findAll();
return $this->render('articles/index.html.twig',['articles'=> $articles]);

   
 }
  

 public function save() {
   $entityManager = $this->entityManager->getManager();
   $article = new Article();
   $article->setNom('Article 1');
   $article->setPrix(1000);
   
   $entityManager->persist($article);
   $entityManager->flush();
   return new Response('Article enregisté avec id '.$article->getId());
   }
  
   public function new(Request $request) {
      $article = new Article();
      $form = $this->createForm(ArticleType::class,$article);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {
      $article = $form->getData();
      $entityManager = $this->entityManager->getManager();
      $entityManager->persist($article);
      $entityManager->flush();
      return $this->redirectToRoute('article_list');
      }
      return $this->render('articles/new.html.twig',['form' => $form->createView()]);}


public function show($id) {
         $article = $this->entityManager->getRepository(Article::class)->find($id);
         return $this->render('articles/show.html.twig', array('article' => $article));
              }

public function edit(Request $request, $id) {
        $article = new Article();
        $article = $this->entityManager->getRepository(Article::class)->find($id);
                
        $form = $this->createForm(ArticleType::class,$article);
                
                $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid()) {
                
                $entityManager = $this->entityManager->getManager();
                $entityManager->flush();
                
                return $this->redirectToRoute('article_list');} 
                return $this->render('articles/edit.html.twig', ['form' => $form->createView()]);
                
            }    

                public function delete(Request $request, $id) {
                  $article = $this->entityManager->getRepository(Article::class)->find($id);
                  
                  $entityManager = $this->entityManager->getManager();
                  $entityManager->remove($article);
                  $entityManager->flush();
                  
                  $response = new Response();
                  $response->send();
                  return $this->redirectToRoute('article_list');
                  }    

                  public function newCategory(Request $request) {
                     $category = new Category();
                     $form = $this->createForm(CategoryType::class,$category);
                     $form->handleRequest($request);
                     if($form->isSubmitted() && $form->isValid()) {
                     $article = $form->getData();
                     $entityManager = $this->entityManager->getManager();
                     $entityManager->persist($category);
                     $entityManager->flush();
                     }  
                     return $this->render('articles/newCategory.html.twig',['form'=>$form->createView()]);
                      }
                               
                                        
     
}
