<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Customer;
use App\Entity\Truck;
use App\Entity\Product;
use App\Repository\CustomerRepository;
use App\Repository\TruckRepository;
use App\Repository\ProductRepository;
use App\Form\FormCustomerType;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;

class CustomerController extends AbstractController
{
    #[Route('/customer', name: 'customer')]
    public function index(UserInterface $user): Response
    {
        return $this->render('customer/index.html.twig', [
            'username' => $user->getUsername(),
        ]);
    }


    #[Route('/customer/createcustomer', name: 'createcustomer')]
    public function createcustomer(Request $request, UserInterface $user){
        $customer = new Customer();
        $form = $this->createForm(FormCustomerType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $customer->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            $this->addFlash('notice','Enregistrement Réussi!');

            return $this->redirectToRoute('customer');
        } else {

            $this->addFlash('notice','Votre inscription n\'a pas été prise en compte');
        }

        return $this->render('customer/createcustomer.html.twig',[
            'form' => $form->createView(),
            'last_name' => 'Nom de famille',
            'first_name' => 'Prénom',
            'phone_number' => 'Téléphone',
            
        ]);

    }

    #[Route('/customer/updatecustomer/{id}', name: "updatecustomer")]
    public function updateustomer(Request $request,UserInterface $user,$id, EntityManagerInterface $em){
        $customer = $em->getRepository(Customer::class)->find($id);
        $form = $this->createForm(FormCustomerType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $customer->setUser($this->getUser());
            $em->persist($customer);
            $em->flush();
    
            $this->addFlash('notice','Mise à jour réussie!');
    
            return $this->redirectToRoute('customer');
        }
    
        return $this->render('customer/updatecustomer.html.twig',[
            'form' => $form->createView(),
            'last_name' => 'Nom de famille',
            'first_name' => 'Prénom',
            'phone_number' => 'Téléphone',

        ]);

    
    }

// Methode pour routage et affichage de page personnalisé si connecté

    #[Route('/customer/ownpage/{id}', name: 'ownpage')]
    public function ownpage($id, UserInterface $user, EntityManagerInterface $em){
        $data = $em->getRepository(Customer::class)->find($id);
        return $this->render('customer/ownpage.html.twig',[
            'customer' => $data,
            'id' => $user->getCustomer()->getId(),
        ]);
    }

//Liste compléte des Trucks à afficher dans customers

        #[Route('/customer/alltrucks', name: 'alltrucks')]
        public function alltrucks(EntityManagerInterface $em){
            $data = $em->getRepository(Truck::class)->findAll();
            return $this->render('customer/alltrucks.html.twig',[
                'trucks' => $data,
                ]);
        }

            
            
    #[Route('/customer/showmenu/{id}', name: 'showmenu')]
        public function showmenu($id, EntityManagerInterface $em){
        $truck = $em->getRepository(Truck::class)->find($id);
        $product = $em->getRepository(Product::class)->findBy(array('truck' => $truck ));
        // $data = $this->getDoctrine()->getRepository(Product::class)->findBy([], ['truck_id' => $product->getTruck($this->getUser()->getTruck())]);
        return $this->render('customer/showmenu.html.twig', [
            'list' => $product,
            'truck' => $truck
        ]);
        }

    // #[Route('/customer/panier', name: 'cart_index')]

    //     public function panier()
    //     {
    //         return $this->render('customer/panier.html.twig', []);
    //     }

    #[Route('/customer/add/{id}', name:'cart_add')]
    public function add($id, Request $request){
        $session = $request->getSession();
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        
        $session->set('panier', $panier);

        dd($session->get('panier'));
    }

}