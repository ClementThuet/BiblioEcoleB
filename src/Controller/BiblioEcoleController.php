<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use App\Entity\Eleve;
use App\Entity\Livre;
use App\Entity\Emprunt;
use App\Entity\Image;

class BiblioEcoleController extends AbstractController{
    
    public function accueil()
    {
        $eleves = $this->getDoctrine()->getRepository(Eleve::class)->findAll();
        return $this->render('accueil.html.twig',['eleves'=>$eleves]);
    }
    
    public function bibliotheque()
    {
        $livres = $this->getDoctrine()->getRepository(Livre::class)->findAll();
        return $this->render('bibliotheque.html.twig',['livres'=>$livres]);
    }
    
    public function ajouterLivre()
    {
        return $this->render('ajouterLivre.html.twig');
    }
    
    public function enregistrerLivre()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $livre = new Livre();
        //Vérfication que le titre n'est pas vide
        if (!empty($_POST['titre']) AND !ctype_space($_POST['titre']) ) 
        {
            $livre->setTitre($_POST['titre']);
            $livre->setAuteur($_POST['auteur']);
            $livre->setTheme($_POST['theme']);
            $livre->setCode($_POST['code']);
            $livre->setBibliothequeOrigine($_POST['biblioOrigine']);
            $livre->setNbEmprunt(0);
            $livre->setEstEmprunte(0);
            
            $target_dir = "uploads/livres/";
            $target_file = $target_dir . basename($_FILES["photoLivre"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"]) and strlen($_FILES["photoLivre"]['name'])>0 ) {
                $check = getimagesize($_FILES["photoLivre"]["tmp_name"]);
                if($check !== false) {
                    if (move_uploaded_file($_FILES["photoLivre"]["tmp_name"], $target_file)) {
                        $image = new Image();
                        $image->setUrl($target_file);
                        $image->setAlt($_FILES["photoLivre"]["name"]);
                        $livre->setImage($image);
                        $entityManager->persist($image);
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } 
            }
            $entityManager->persist($livre);
            $entityManager->flush();
        }
        return $this->redirectToRoute('bibliotheque');
    }
    
    public function modifierLivre($idLivre)
    {
        $livre = $this->getDoctrine()->getRepository(Livre::class)->find($idLivre);
        return $this->render('modifierLivre.html.twig',['livre'=>$livre]);
    }
    
    public function enregistrerModificationLivre($idLivre)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $livre = $this->getDoctrine()->getRepository(Livre::class)->find($idLivre);
        //Vérification que le nom n'est pas vide
        if (!empty($_POST['titre']) AND !ctype_space($_POST['titre']) ) 
        {
            $livre->setTitre($_POST['titre']);
            $livre->setAuteur($_POST['auteur']);
            $livre->setTheme($_POST['theme']);
            $livre->setCode($_POST['code']);
            $livre->setBibliothequeOrigine($_POST['biblioOrigine']);
            
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])){
                $target_dir = "uploads/livres/";
                $target_file = $target_dir . basename($_FILES["photoLivre"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                if(strlen($_FILES["photoLivre"]['name'])>0 ){
                    $check = getimagesize($_FILES["photoLivre"]["tmp_name"]);
                    if($check !== false) {
                        if (move_uploaded_file($_FILES["photoLivre"]["tmp_name"], $target_file)) {
                            $image = new Image();
                            $image->setUrl($target_file);
                            $image->setAlt($_FILES["photoLivre"]["name"]);
                            $livre->setImage($image);
                            $entityManager->persist($image);
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    } else {
                        echo "File is not an image.";
                    }
                }
            }
            $entityManager->persist($livre);
            $entityManager->flush();
        }
        return $this->redirectToRoute('livre_modifier',['idLivre'=>$idLivre]);
    }
    
    public function supprimerLivre($idLivre)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $livre = $this->getDoctrine()->getRepository(Livre::class)->find($idLivre);
        $entityManager->remove($livre);
        $entityManager->flush();
        return $this->redirectToRoute('bibliotheque');
    }
    
    public function eleves()
    {
        $eleves = $this->getDoctrine()->getRepository(Eleve::class)->findAll();
        return $this->render('eleves.html.twig',['eleves'=>$eleves]);
    }
    
    public function ajouterEleve()
    {
        return $this->render('ajouterEleve.html.twig');
    }
    
    public function enregistrerEleve()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $eleve = new Eleve();
        //Vérfication que le nom n'est pas vide
        if (!empty($_POST['nom']) AND !ctype_space($_POST['nom']) ) 
        {
            $eleve->setNom($_POST['nom']);
            $eleve->setPrenom($_POST['prenom']);
            $eleve->setNiveau($_POST['niveau']);
            
            $target_dir = "uploads/eleves/";
            $target_file = $target_dir . basename($_FILES["photoEleve"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"]) and strlen($_FILES["photoEleve"]['name'])>0) {
                $check = getimagesize($_FILES["photoEleve"]["tmp_name"]);
                if($check !== false) {
                    if (move_uploaded_file($_FILES["photoEleve"]["tmp_name"], $target_file)) {
                        $image = new Image();
                        $image->setUrl($target_file);
                        $image->setAlt($_FILES["photoEleve"]["name"]);
                        $eleve->setImage($image);
                        $entityManager->persist($image);
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    echo "File is not an image.";
                }
            }
            $entityManager->persist($eleve);
            $entityManager->flush();
        }
        return $this->redirectToRoute('eleves');
    }
    
    public function modifierEleve($idEleve)
    {
        $eleve = $this->getDoctrine()->getRepository(Eleve::class)->find($idEleve);
        return $this->render('modifierEleve.html.twig',['eleve'=>$eleve]);
    }
    public function enregistrerModificationEleve($idEleve)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $eleve = $this->getDoctrine()->getRepository(Eleve::class)->find($idEleve);
        //Vérification que le nom n'est pas vide
        if (!empty($_POST['nom']) AND !ctype_space($_POST['nom']) ) 
        {
            $eleve->setNom($_POST['nom']);
            $eleve->setPrenom($_POST['prenom']);
            $eleve->setNiveau($_POST['niveau']);
            
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])){
                $target_dir = "uploads/eleves/";
                $target_file = $target_dir . basename($_FILES["photoEleve"]["name"]);
                //Vérification qu'une image a été uploadé, sinon pas de modification
                if(strlen($_FILES["photoEleve"]['name'])>0 ){
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $check = getimagesize($_FILES["photoEleve"]["tmp_name"]);
                    if($check !== false) {
                        if (move_uploaded_file($_FILES["photoEleve"]["tmp_name"], $target_file)) {
                            $image = new Image();
                            $image->setUrl($target_file);
                            $image->setAlt($_FILES["photoEleve"]["name"]);
                            $eleve->setImage($image);
                            $entityManager->persist($image);
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    }
                }
            }
            $entityManager->persist($eleve);
            $entityManager->flush();
        }
        return $this->redirectToRoute('eleve_modifier',['idEleve'=>$idEleve]);
    }
    
    public function supprimerEleve($idEleve)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $eleve = $this->getDoctrine()->getRepository(Eleve::class)->find($idEleve);
        $entityManager->remove($eleve);
        $entityManager->flush();
        return $this->redirectToRoute('eleves');
    }
    
    public function emprunts()
    {
        $emprunts = $this->getDoctrine()->getRepository(Emprunt::class)->findAll();
        return $this->render('emprunts.html.twig',['emprunts'=>$emprunts]);
    }
    
    public function choixEleve($idEleve)
    {
        $eleve = $this->getDoctrine()->getRepository(Eleve::class)->find($idEleve);
        $livres = $this->getDoctrine()->getRepository(Livre::class)->findAll();
        $emprunt=$eleve->getEmprunt();
        if($emprunt== NULL){
            
            return $this->render('empruntChoixLivre.html.twig',['eleve'=>$eleve,'livres'=>$livres]);
        }
        else{
            return $this->render('retourEmprunt.html.twig',['emprunt'=>$emprunt,'eleve'=>$eleve,'livres'=>$livres]); 
        }
    }
    
    public function empruntRetour($idEmprunt)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $emprunt = $this->getDoctrine()->getRepository(Emprunt::class)->find($idEmprunt);
        $livre=$emprunt->getLivre();
        $eleve=$emprunt->getEleve();
        if($_POST['code'] ==$livre->getCode())
        {
            $emprunt->setDateRetour(new DateTime);
            $livre->setEmprunt(NULL);
            $livre->setDateDernierRetour(new DateTime);
            $eleve->setEmprunt(NULL);
            $entityManager->persist($emprunt);
            $entityManager->persist($livre);
            $entityManager->persist($eleve);
            $entityManager->flush();
            return $this->render('retourEmpruntSucces.html.twig',['emprunt'=>$emprunt]); 
        }
        else
        {
            $messageRetour='Code incorrecte';
            return $this->render('retourEmprunt.html.twig',['emprunt'=>$emprunt,'messageRetour'=>$messageRetour]); 
        }
    }
    
    public function choixLivre($idLivre,$idEleve)
    {
        $eleve = $this->getDoctrine()->getRepository(Eleve::class)->find($idEleve);
        $livre = $this->getDoctrine()->getRepository(Livre::class)->find($idLivre);
        
        if($livre->getEmprunt()==NULL && $eleve->getEmprunt() == NULL)
        {
            $emprunt = new Emprunt();
            $emprunt->setDateEmprunt(new \DateTime());
            $emprunt->setEleve($eleve);
            $eleve->setEmprunt($emprunt);
            $livre->setEmprunt($emprunt);
            $livre->setDateDernierEmprunt(new \DateTime());
            $livre->setNbEmprunt($livre->getNbEmprunt()+1);
            $emprunt->setLivre($livre);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emprunt);
            $entityManager->flush();
            return $this->render('recapitulatifEmprunt.html.twig',['eleve'=>$eleve,'livre'=>$livre]); 
        }
        else{
            return $this->redirectToRoute('accueil');
        }
    }
}
