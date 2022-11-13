<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Address;
use App\Entity\Product;
use App\Entity\Truck;
use App\Entity\Picture;
use App\Entity\User;
use App\Service\CallApiServiceGPS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;


class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CallApiServiceGPS $callApiServiceGPS, EntityManagerInterface $em): Response
    {


        $allTrucksAdd = $em->getRepository(Address::class)->skipAddresses();
        $fullAdd = $em->getRepository(Address::class)->findAll();
        // dd($fullAdd);
        //$r =les noms de mes points gps

        // $days = [];
        // foreach($fullAdd as $data){
        //     $truck = $data->getTruck()->first();
        //     $days_of_presence = unserialize($truck->getAddress());
        //     array_push($days,$days_of_presence);
        //     }
        // dd($days);
        $day = Date('D');
        $r = [];
        foreach ($fullAdd as $data) {
            $arrayDay = $data->getDaysOfPresence();
            if (array_search($day, $arrayDay) !== false) {
                $truck = $data->getTruck()->first();
                $truckName = $truck->getNameTruck();
                $truckId = $data->getTruck()->first()->getId();
                array_push($r, [$truckName, $truckId]);
            }
        }


        $addConcat = [];
        foreach ($allTrucksAdd as $value) {
            if (array_search($day, $value['days_of_presence']) !== false) {
                $number = $value['street_number'];
                $street = $value['street_name'];
                $post_code = $value['post_code'];
                $city = $value['city'];
                //Je concaténe $street avec des +
                $street = str_replace(" ", "+", $street);
                //Je concatene tous les éléments de mon adresse avec des +
                $full = $number . "+" . $street . "+" . $post_code . "+" . $city;
                array_push($addConcat, $full);
            }
        }
        // Je récupére les points gps de mes adresses dans $coordinate
        $coordinates = [];
        //Penser une fonction asynchrone pour la requete et stocker la réponse de l'API dans $coordonate
        foreach ($addConcat as $value) {
            $data = $callApiServiceGPS->getFranceApi($value);
            array_push($coordinates, $data);
        }
        // dd($r);     
        for ($i = 0; $i < count($coordinates); $i++) {
            array_push($coordinates[$i], $r[$i]);
        }


        $coordinates = json_encode($coordinates);
        // dd($coordinates);

        // dd(Date('D'));


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'coordinates' => $coordinates
        ]);
    }

    #[Route('/foodtrucks', name: 'foodtrucks')]
    public function foodtrucks(EntityManagerInterface $em)
    {

        phpinfo();
        $allTrucks = $em->getRepository(Truck::class)->truckCards();
        $allPictures = $em->getRepository(Picture::class)->findAll();
        $trucksInfos = [];
        foreach ($allTrucks as $truck) {
            $info = [];
            $id = $truck['id'];
            array_push($info, $id);
            $name = $truck['name_truck'];
            array_push($info, $name);
            $style = $truck['style'];
            array_push($info, $style);
                if ($em->getRepository(Picture::class)->skipPictures($id)) {
                    $picture = $em->getRepository(Picture::class)->skipPictures($id);
                    // $pictname = $picture->getName();
                    array_push($info, $picture);
                }
    
            array_push($trucksInfos, $info);
        }

        // dd($trucksInfos);

        return $this->render('home/foodtrucks.html.twig', [
            'trucksInfos' => $trucksInfos,

        ]);
    }

    #[Route('/foodtruck/{id}', name: 'foodtruckCard')]
    public function foodtruckCard($id, EntityManagerInterface $em)
    {

        $data = $em->getRepository(Truck::class)->find($id);
        $value = $data->getId();
        $coord = $em->getRepository(Truck::class)->truckCoord($value);
        $boissons = $em->getRepository(Product::class)->byTruck($value, 'boisson');
        $sandwiches = $em->getRepository(Product::class)->byTruck($value, 'sandwich');
        $kebabs = $em->getRepository(Product::class)->byTruck($value, 'kebab');
        $menus = $em->getRepository(Product::class)->byTruck($value, 'menu');
        $specialites = $em->getRepository(Product::class)->byTruck($value, 'specialité');
        $addresses = $em->getRepository(Address::class)->findMyAddresses($value);

        return $this->render('home/foodtruckCard.html.twig', [
            'truck' => $coord,
            'boissons' => $boissons,
            'sandwiches' => $sandwiches,
            'kebabs' => $kebabs,
            'menus' => $menus,
            'specialites' => $specialites,
            'addresses' => $addresses,
        ]);
    }
}
