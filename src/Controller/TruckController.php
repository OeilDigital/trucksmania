<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Truck;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Address;
use App\Form\TruckRegisterType;
use App\Form\FormProductType;
use App\Form\FormAddressType;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;


class TruckController extends AbstractController
{
    #[Route('/truck', name: 'truck')]
    public function index(UserInterface $user): Response
    {
        return $this->render('truck/index.html.twig', [
            'username' => $user->getUsername(),
            'controller_name' => 'ReactController'

        ]);

        
    }

    // Creation d'un profil Truck suite à inscription User

        #[Route('/truck/create', name: 'create')]

        public function create(Request $request, UserInterface $user, EntityManagerInterface $em){
            $truck = new Truck();
            $form = $this->createForm(TruckRegisterType::class, $truck);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $truck->setUser($this->getUser());
                $em->persist($truck);
                $em->flush();
    
                $this->addFlash('notice','Enregistrement de votre foodtruck réussi!');
    
                return $this->redirectToRoute('truck');
            } else {
    
                // $this->addFlash('notice','L\'enregistrement de votre foodtruck n\'a pas été prise en compte');
            }
    
            return $this->render('truck/create.html.twig',[
                'form' => $form->createView(),
                'name_truck' => 'Nom d\'enseigne',
                'style' => 'Style',
                'last_name' => 'Nom de famille',
                'first_name' => 'Prénom',
                'phone_number' => 'Téléphone',
                'siret' => 'Numéro de siret',
            ]);
    
        }

//  Mise à jour des informations d'inscription Truck

        #[Route('/truck/update/{id}', name: "update")]
        public function update(Request $request,UserInterface $user,$id, EntityManagerInterface $em){
            $truck = $this->getDoctrine()->getRepository(Truck::class)->find($id);
            $form = $this->createForm(TruckRegisterType::class, $truck);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $truck->setUser($this->getUser());
                $em->persist($truck);
                $em->flush();
        
                $this->addFlash('notice','Mise à jour de votre truck réussie!');
        
                return $this->redirectToRoute('truck');
            }
        
            return $this->render('truck/update.html.twig',[
                'form' => $form->createView(),
                'name_truck' => 'Nom d\'enseigne',
                'style' => 'Style',
                'last_name' => 'Nom de famille',
                'first_name' => 'Prénom',
                'phone_number' => 'Téléphone',
                'siret' => 'Numéro de siret',
            ]);
        
            }

// Methode pour routage et affichage de page personnalisé si connecté

        #[Route('/truck/mytruck/{id}', name: 'truck_mytruck')]
        public function mytruck($id,EntityManagerInterface $em, UserInterface $user){
            $data = $em->getRepository(Truck::class)->find($id);
            $value = $data->getId();
            $products = $em->getRepository(Product::class)->findBy(array('truck' => $user->getTruck()));
            $addresses = $em->getRepository(Address::class)->findMyAddresses($value);
            return $this->render('truck/mytruck.html.twig',[
                'truck' => $data,
                'products' => $products,
                'addresses' => $addresses,
                'id' => $user->getTruck()->getId(),
            ]);
        }


// Creation de produits

        #[Route('/truck/createproduct', name: 'truck_createproduct')]
        public function createproduct(Request $request,UserInterface $user, EntityManagerInterface $em){
            $product = new Product();
            $form = $this->createForm(FormProductType::class, $product);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $product->setTruck($this->getUser()->getTruck());
                $em->persist($product);
                $em->flush();
    
                $this->addFlash('notice','Enregistrement du nouveau produit réussi!');
    
                return $this->redirectToRoute('truck_createproduct');
            } else {
    
                // $this->addFlash('notice','L\'enregistrement du nouveau produit n\'a pas été prise en compte');
            }
    
            return $this->render('truck/createproduct.html.twig',[
                'form' => $form->createView(),
                'product_name' => 'Nom du produit',
                'type' => 'Catégorie',
                'price' => 'Prix',
                'description' => 'Description',
                
            ]);
        
        }

    // Affichage de l'ensemble des produit par utilisateur

    #[Route('/truck/menu', name: 'truck_menu')]
    public function menu(ProductRepository $product, UserInterface $user, EntityManagerInterface $em){
    $data = $em->getRepository(Product::class)->findBy(array('truck' => $user->getTruck()));
    // $data = $this->getDoctrine()->getRepository(Product::class)->findBy([], ['truck_id' => $product->getTruck($this->getUser()->getTruck())]);
    return $this->render('truck/menu.html.twig', [
        'list' => $data,
    ]);
    }

// Mise à jour des produit


    #[Route('/truck/updateproduct/{id}', name: "updateproduct")]

    public function updateproduct(Request $request, UserInterface $user, $id, EntityManagerInterface $em){
    $product = $em->getRepository(Product::class)->find($id);
    $form = $this->createForm(FormProductType::class, $product);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
        $product->setTruck($this->getUser()->getTruck());
        $em->persist($product);
        $em->flush();

        $this->addFlash('notice','Mise à jour de votre produit réussie!');

        return $this->redirectToRoute('truck');
    }

    return $this->render('truck/updateproduct.html.twig',[
        'form' => $form->createView(),
        'product_name' => 'Nom du produit',
        'type' => 'Catégorie',
        'price' => 'Prix',
        'description' => 'Description',
        
    ]);

    }

// Supprimer un produit

     #[Route('/truck/delete/{id}', name: "delete")]
     public function delete($id, EntityManagerInterface $em){
        $data = $em->getRepository(Product::class)->find($id);
        $em->remove($data);
        $em->flush();

        $this->addFlash('notice','Données effacées!');

        return $this->redirectToRoute('truck');
        

    }

// Gestion des adresses

// Crèation d'une nouvelle adressse

    #[Route('/truck/createaddress', name: 'createaddress')]
    public function createaddress(Request $request,UserInterface $user, EntityManagerInterface $em){
        $address = new Address();
        $form = $this->createForm(FormAddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            // $data = $form->getData()->getDaysOfPresence();
            // dd($data);
            $address->addTruck($this->getUser()->getTruck());
            $em->persist($address);
            $em->flush();

            $this->addFlash('notice','Enregistrement Réussi!');

            return $this->redirectToRoute('truck');
        } else {

            // $this->addFlash('notice','Votre inscription n\'a pas été prise en compte');
        }

        return $this->render('truck/createaddress.html.twig',[
            'form' => $form->createView(),
            'street_number' => 'N° de voirie',
            'street_name' => 'Nom de voirie',
            'post_code' => 'Code Postal',
            'city' => 'Ville',
            'additional_address' => 'Informations complémentaires',
            'days_of_presence' => 'Jours de présence',
            
        ]);
    
    }

    // Liste des adresses

        #[Route('/truck/listaddress', name: 'truck_listaddress')]
        public function listaddress(AddressRepository $address, UserInterface $user, EntityManagerInterface $em){
            $data = $em->getRepository(Address::class)->findBy(array('truck' => $user->getTruck() ));
            return $this->render('truck/listaddress.html.twig', [
                'list' => $data,
            ]);
            }


    // Mise à jour d'une adresse

        #[Route('/truck/updateaddress/{id}', name: "updateaddress")]
        public function updateaddress(Request $request, UserInterface $user, $id, EntityManagerInterface $em){
            $address = $em->getRepository(Address::class)->find($id);
            $form = $this->createForm(FormAddressType::class, $address);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $address->addTruck($this->getUser()->getTruck());
                $em->persist($address);
                $em->flush();
        
                $this->addFlash('notice','Mise à jour réussie!');
        
                return $this->redirectToRoute('truck');
            }
        
            return $this->render('truck/updateaddress.html.twig',[
                'form' => $form->createView(),
                'street_number' => 'N° de voirie',
                'street_name' => 'Nom de voirie',
                'post_code' => 'Code Postal',
                'city' => 'Ville',
                'additional_address' => 'Informations complémentaires',
                'days_of_presence' => 'Jours de présence',
                
            ]);
        
        }

        #[Route('/truck/deleteaddress/{id}', name: "deleteaddress")]

        public function deleteAddress($id, EntityManagerInterface $em){
        $data = $em->getRepository(Address::class)->find($id);
        $em->remove($data);
        $em->flush();

        $this->addFlash('notice','Données effacées!');

        return $this->redirectToRoute('truck');
        

        }

        
}





