<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function save(Contact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findImbox($query = null, $offset = null, $limit = null): array
    {

        $qb = $this->createQueryBuilder('c')
            ->andWhere('c.status = :status');

        if($query) {
            $qb->andWhere('c.name LIKE :name')->setParameter('name', '%' . $query . '%');
        }

        $qb->setParameter('status', 'new')
            ->orderBy('c.id', 'DESC');

        if($limit) {
            $qb->setMaxResults($limit);
        }

        if($offset) {
            $qb->setFirstResult($offset);
        }


        return $qb->getQuery()->getResult();
    }

    public function findImboxStarred($query = null, $offset = null, $limit = null): array
    {

        $qb = $this->createQueryBuilder('c')
            ->andWhere('c.status = :status')
            ->andWhere('c.star = :star');

        if($query) {
            $qb->andWhere('c.name LIKE :name')->setParameter('name', '%' . $query . '%');
        }

        $qb->setParameter('status', 'new')
            ->setParameter('star', 1)
            ->orderBy('c.id', 'DESC');

        if($limit) {
            $qb->setMaxResults($limit);
        }

        if($offset) {
            $qb->setFirstResult($offset);
        }


        return $qb->getQuery()->getResult();
    }

    public function findImboxTrash($query = null, $offset = null, $limit = null): array
    {

        $qb = $this->createQueryBuilder('c')
            ->andWhere('c.status = :status');

        if($query) {
            $qb->andWhere('c.name LIKE :name')->setParameter('name', '%' . $query . '%');
        }

        $qb->setParameter('status', 'trash')
            ->orderBy('c.id', 'DESC');

        if($limit) {
            $qb->setMaxResults($limit);
        }

        if($offset) {
            $qb->setFirstResult($offset);
        }


        return $qb->getQuery()->getResult();
    }

    public function findImboxArchived($query = null, $offset = null, $limit = null): array
    {

        $qb = $this->createQueryBuilder('c')
            ->andWhere('c.status = :status');

        if($query) {
            $qb->andWhere('c.name LIKE :name')->setParameter('name', '%' . $query . '%');
        }

        $qb->setParameter('status', 'archived')
            ->orderBy('c.id', 'DESC');

        if($limit) {
            $qb->setMaxResults($limit);
        }

        if($offset) {
            $qb->setFirstResult($offset);
        }


        return $qb->getQuery()->getResult();
    }

    public function toggleStarStatus(int $contactId): void
    {
        $entityManager = $this->getEntityManager();
        $contact = $entityManager->find(Contact::class, $contactId);

        if ($contact !== null) {

            $currentStarStatus = $contact->isStar();
            $newStarStatus = $currentStarStatus == false ? 1 : 0;
            $contact->setStar($newStarStatus);

            $entityManager->flush();
        }
    }

    public function toggleStatus(int $contactId): void
    {
        $entityManager = $this->getEntityManager();
        $contact = $entityManager->find(Contact::class, $contactId);

        if ($contact !== null) {

            $contact->setStatus('trash');

            $entityManager->flush();
        }
    }

    public function toFile(int $contactId): void
    {
        $entityManager = $this->getEntityManager();
        $contact = $entityManager->find(Contact::class, $contactId);

        if ($contact !== null) {

            $contact->setStatus('archived');
            $entityManager->flush();
        }
    }

    public function unfiling(int $contactId): void
    {
        $entityManager = $this->getEntityManager();
        $contact = $entityManager->find(Contact::class, $contactId);

        if ($contact !== null) {

            $contact->setStatus('new');
            $entityManager->flush();
        }
    }

//    public function findOneBySomeField($value): ?Contact
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
