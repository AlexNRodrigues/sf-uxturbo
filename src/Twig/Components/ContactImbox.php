<?php

namespace App\Twig\Components;

use App\Repository\ContactRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
final class ContactImbox
{
    use DefaultActionTrait;

    public int $page = 1;
    public int $offset = 0;
    public int $limit = 4;
    public int $currentPage = 1;
    public int $total = 0;

    #[LiveProp(writable: true)]
    public int $idContact = 0;

    #[LiveProp(writable: true)]
    public ?string $query = null;

    public function __construct(private ContactRepository $contactRepository)
    {
    }

    public function getContacts()
    {
       return $this->contactRepository->findImbox($this->query, $this->offset, $this->limit);
    }

    public function getTotalContacts()
    {
        return count($this->contactRepository->findImbox($this->query));
    }

    #[LiveAction]
    public function paginateContacts(#[LiveArg] int $page)
    {
        $this->offset = (($page - 1) * $this->limit);
        $this->page = $page;
    }

    #[LiveAction]
    public function star(#[LiveArg] int $id): void
    {
        $this->contactRepository->toggleStarStatus($id);
    }

    #[LiveAction]
    public function trash(#[LiveArg] int $id): void
    {
        $this->contactRepository->toggleStatus($id);
    }

    #[LiveAction]
    public function toFile(#[LiveArg] int $id): void
    {
        $this->contactRepository->toFile($id);
    }
}
