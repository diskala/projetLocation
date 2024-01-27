<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Car;
use App\Entity\User;
use App\Entity\Agence;
use App\Entity\Image;
use App\Entity\Invoice;
use Faker\Core\DateTime;
use App\Entity\Reservation;

use Doctrine\Persistence\ObjectManager;
use function Symfony\Component\Clock\now;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Role\Role;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //instancier Faker pour les données aléatoire en français
        $faker = Factory::create($fakerLocale = 'fr_FR');
        $carArray=[];
        // on crée un tableau vide qui contient tous les Utilisateurs
        // on boucle avec i=10  pour pouvoir charger 10 utilisateurs dans la base de données
         $userArray=[];
        for($i=0; $i<10; $i++)
        {

            $user = new User();
            $user->setEmail($faker->email());
            if($i==7)
            {
                $user->setRoles(['ROLE-ADMIN']);
            }
            else
            {
                $user->setRoles(['ROLE-USER']);
            }
            $user->setPassword('$2y$13$focFB/V9Eus4uhQ6rw42deLwG.Db9aDlPjH3evnAwViSbBtHw3Fmu');
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setAddress($faker->address());
            $user->setPhone($faker->phoneNumber());
            $user->setBirthDate($faker->dateTimeBetween('-70 years', '-18 years'));
            $user->setDateDrivingLicence($faker->dateTimeBetween('-30 years', '-2 years'));
            $user->setCampany($faker->name());
            $user->setSiret($faker->numberBetween(1111111111111 , 9999999999999));
            array_push($userArray, $user);
            $manager->persist($user);
   

        }
        

        $imagesTab=[];
        $imagesCsv="import/photos-voitures.csv";
        $fileCsv=fopen($imagesCsv, "r");
        while(!feof($fileCsv))
        {
          $arrayImages[]=fgetcsv($fileCsv, 300, ',');
        }
  
        $countArrayimages=count($arrayImages);
       
        $j=0;
  
        for($i=0; $i<$countArrayimages - 2 ; $i++)
        {
          $j++;

          $image=new Image();
          $image->setSlug($arrayImages[$i][0]);
          $image->setImage1($arrayImages[$i][1]);
          $image->setImage2($arrayImages[$i][2]);
          $image->setImage3($arrayImages[$i][3]);
          $image->setImage4($arrayImages[$i][4]);
          $image->setImage5($arrayImages[$i][5]);
          $image->setImage6($arrayImages[$i][6]);
          $image->setImage7($arrayImages[$i][7]);
          $image->setImage8($arrayImages[$i][8]);
          $image->setImage9($arrayImages[$i][9]);
          $image->setImage10($arrayImages[$i][10]);
          // $image->setCars($carArray[$i]);
          array_push($imagesTab, $image);
          $manager->persist($image);
  
  
  
        }


       
  

        // on importe un fichier CSV pour charger la table Car dans la base de données 
       $carArray=[];
        $fichier= "import/voiture.csv";
        // on ouvre le fichier en lecture seul
        $fichiercsv=fopen($fichier, 'r');

        // on stock chaque ligne dans un tableau
        while(! feof($fichiercsv))
        {
            $arraycsv[]=fgetcsv($fichiercsv, 300, ',');
        }
        $countArraycsv=count($arraycsv);
        // on fait une boucle pour pouvoir charger chaque ligne
        // le compteur $j pour les colones de tableau;
        $j=0;
        for($i = 1; $i <  $countArraycsv - 3; $i++)
        {
          $j++;
          
          $car= new Car();
        
          $car->setBrand($arraycsv[$i][0]);
          $car->setModel($arraycsv[$i][1]);
          $car->setCategory($arraycsv[$i][2]);
          $car->setEnergy($arraycsv[$i][3]);
          $car->setPower($arraycsv[$i][4]);
          $car->setGearBox($arraycsv[$i][5]);
          $car->setNumberPlace($arraycsv[$i][6]);
          $car->setPriceDay($arraycsv[$i][7]);
          $car->setPriceDPKM($arraycsv[$i][8]);
          $car->setPriceKmUnlimited($arraycsv[$i][9]);
          $car->setStock($arraycsv[$i][10]);
          $car->setBail($arraycsv[$i][11]);
          // Available colonne  boolean aléatoire
          $car->setAvailable($faker->boolean());
          $car->setImage($imagesTab[$i]);
          array_push($carArray, $car);
          $manager->persist($car);

        }
       

       





        $reservedArray=[];
      for($i=0;$i<10;$i++)
      {
        
        $reservation=new Reservation();
        
         
         
          

        $reservation->setStartDate($faker->dateTimeBetween('-2 week', '-1 week'));
        $reservation->setEndDate($faker->dateTimeBetween('+1 week', '+3 week'));
         $reservation->setBail($faker->boolean());
         $reservation->setOptionDriver($faker->boolean());
         $reservation->setOptChildSeat($faker->boolean());
         $reservation->setDecoration($faker->boolean());
        //  $reservation->setDrivingLicense($faker->mimeType(),$faker->fileExtension());
         $reservation->setDayDate($faker->dateTimeBetween('-3 week', '-1 week'));
         $reservation->setUsers($userArray[$i]);
         $reservation->setCar($carArray[$i]);
          array_push($reservedArray, $reservation);
         $manager->persist($reservation);

      }
       
      // $invoiceArray=[];
      // for($i=0; $i<5; $i++)
      // {
      //   $invoice=new Invoice();
      //   $invoice->setPriceHT($faker->randomFloat(1000, 4200, 5000));
      //   $invoice->setPriceTTC($faker->randomFloat(1500, 4800, 6000));
      //   $invoice->setReserve($reservedArray[$i]);
      //   $invoice->setNumber($faker->numberBetween(1111111111 , 9999999999));
        
      //   array_push($invoiceArray, $invoice);
      //   $manager->persist($invoice);

      // }


     $objetDepartement=['Paris', 'Alpes-Maritimes', 'Gironde', 'Moselle',
                       'Haute-Savoie', 'Vendée', 'Gard', 'Rhône',
                        'Pyrénées-Orientales', 'Haute-Garonne'];

     $objetCity=['paris', 'Nice', 'Bordeaux', 'Metz', 'Annecy', 'La Roche-sur-Yon', 'Nîmes', 'Lyon', 'Perpignan', 'Toulouse'];
     $objetZipcode=[75008, 06200, 30072, 57000, 74000, 85000, 30900, 69620, 66870, 31555];
     

      
      for($i=0; $i<10; $i++)
      {
        $agence=new Agence();
        $agence->setAddress($faker->address());
        $agence->setPostalCode($objetZipcode[$i]);
        $agence->setCity($objetCity[$i]);
        $agence->setDepartement($objetDepartement[$i]);

        $manager->persist($agence);
      }
       
     

        $manager->flush();
    }
}
