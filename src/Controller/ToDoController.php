<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController extends AbstractController
{
    #[Route('/todo', name: 'index')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if(!$session->has('todo')){
            $todo = array(  'achat' => 'acheter une cle usb', 
                            'cours' => 'Finaliser mon cours', 
                            'choix' => 'effectuer son propre choix');
            $session->set('todo', $todo);
            $this->addFlash(
               'success',
               'Todo initialisé avec succès'
            );
        }

        return $this->render('to_do/index.html.twig');
    }
    #[Route('/todo/add/{name}/{content}', name: 'todo.add', defaults: ['content' => 'better'])]
    public function add(Request $request, $name, $content): Response
    {
        $session = $request->getSession();
        if($session->has('todo')){
            $todo = $session->get('todo');
            if(isset($todo[$name])){
                $this->addFlash(
                    'error',
                    "La liste contient deja une clé $name"
                 );
            }else{
                $todo[$name] = $content;
                $this->addFlash(
                    'success',
                    "La liste a ete mis a jour avec la nouvelle clé $name"
                 );
                $session->set('todo', $todo);
            }
            return $this->redirectToRoute('index');
        }else{
            $this->addFlash(
                'error',
                'La liste de Todo n\'existe pas'
             );
            return $this->forward('App/Controller/ToDoController::index');
        }

        
    }
    #[Route('/todo/update/{name}/{content?test}', name: 'todo.update')]
    public function update(Request $request, $name, $content): Response
    {
        $session = $request->getSession();
        if($session->has('todo')){
            $todo = $session->get('todo');
            if(isset($todo[$name])){
                $todo[$name] = $content;
                $this->addFlash(
                    'success',
                    "La liste a ete mis a jour avec la nouvelle valeur $content pour la clé $name"
                 );
                $session->set('todo', $todo);
            }else{
                $this->addFlash(
                    'error',
                    "La clé $name n'existe pas!"
                 );
            }
            return $this->redirectToRoute('index');
        }else{
            $this->addFlash(
                'error',
                'La liste de Todo n\'existe pas'
             );
            return $this->forward('App/Controller/ToDoController::index');
        }

        
    }
    #[Route('/todo/delete/{name}', name: 'todo.delete')]
    public function delete(Request $request, $name): Response
    {
        $session = $request->getSession();
        if($session->has('todo')){
            $todo = $session->get('todo');
            if(isset($todo[$name])){
                unset($todo[$name]);
                $this->addFlash(
                    'success',
                    "La liste a ete mis a jour en supprimant la clé $name"
                 );
                 $session->set('todo', $todo);
            }else{
                $this->addFlash(
                    'error',
                    "La liste ne contient pas une clé $name"
                 );
            }
            return $this->redirectToRoute('index');
        }else{
            $this->addFlash(
                'error',
                'La liste de Todo n\'existe pas'
             );
            return $this->forward('App/Controller/ToDoController::index');
        }

        
    }
    #[Route('/todo/reset', name: 'todo.reset')]
    public function reset(Request $request): Response
    {
        $session = $request->getSession();
        if($session->has('todo')){
            $this->addFlash(
                'success',
                "La liste a ete supprimé avec succes"
             );
             $session->remove('todo');
            return $this->redirectToRoute('index');
        }else{
            $this->addFlash(
                'error',
                'La liste de Todo n\'existe pas'
             );
            return $this->forward('App/Controller/ToDoController::index');
        }
    }
    
}
