<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Vinyle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vinyle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vinyle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vinyle[]    findAll()
 * @method Vinyle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VinyleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vinyle::class);
    }

    // /**
    //  * @return Vinyle[] Returns an array of Vinyle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    //créée une fonction pour afficher nos vinyles par id desc
    public function findAllVinylesDESC(){
        //création d'une requete
        return $this->createQueryBuilder('vinyle')
        //on selectionne toutes les colonnes de la table vinyle
            ->orderBy('vinyle.id', 'DESC')
            //on execute la requete
            ->getQuery()
            //on retourne le resultat
            ->getResult();
    }

    //function pour afficher les 12 derniers vinyles
    public function findLastVinyles(){
        //création d'une requete
        return $this->createQueryBuilder('vinyle')
        //on selectionne toutes les colonnes de la table vinyle
            ->orderBy('vinyle.id', 'DESC')
            //on execute la requete
            ->setMaxResults(12)
            //on retourne le resultat
            ->getQuery()
            ->getResult();
    }

    //function pour afficher les 8 derniers vinyles ajoutés (pour l'accueil)
    public function findVinylesForHome(){
        //création d'une requete
        return $this->createQueryBuilder('vinyle')
        //on selectionne toutes les colonnes de la table vinyle
            ->orderBy('vinyle.id', 'DESC')
            //on execute la requete
            ->setMaxResults(8)
            //on retourne le resultat
            ->getQuery()
            ->getResult();
    }

    /**
     * function pour afficher les vinyles avec l'outil recherche
     * @return Vinyle[] Returns an array of Vinyle objects
     */
    public function findWithSearch(Search $search){
        //création d'une requete
        $query = $this->createQueryBuilder('v')
        //on selectionne toutes les colonnes de la table vinyle
            ->select('s', 'v')
            //on selectionne les colonnes de la table styles
            ->leftJoin('v.Style', 's');
            //jointure sur la colonne v.Style qui est égale à la colonne Styles.id

        if(!empty($search->categorie)){
            //si la categorie n'est pas vide
            $query->where('s.id IN (:categorie)')
            //on selectionne les vinyles qui ont le style dans la categorie
                ->setParameter('categorie', $search->categorie);
                //on rempli la variable categorie avec les valeurs de la variable $search->categorie
        }


        if (!empty($search->string)){
            //si la chaine de caractere n'est pas vide
             //là ou le nom du vinyle contient la chaine de caractere (objet $search->string)
            $query->andWhere('v.name LIKE :string')
            // si c'est contenu dans le nom du Vinyle 
                  ->orWhere('v.artiste LIKE :string')
                    // ou si c'est contenu dans le nom d'artiste
                ->setParameter('string', "%{$search->string}%");
                //on rempli la variable string avec les valeurs de la variable $search->string
        }

        return $query->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Vinyle
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
