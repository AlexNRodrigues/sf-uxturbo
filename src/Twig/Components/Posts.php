<?php

namespace App\Twig\Components;

use App\Repository\PostsRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
final class Posts
{
    use DefaultActionTrait;

    public int $page = 1;
    public int $offset = 0;
    public int $limit = 9;
    public int $currentPage = 1;
    public int $total = 0;

    #[LiveProp(writable: true)]
    public ?string $query = null;

    public function __construct(private PostsRepository $postsRepository)
    {
    }

    public function getPosts(): array
    {
        return $this->postsRepository->findPosts($this->query, $this->offset, $this->limit);
    }

    public function getTotalContacts()
    {
        return count($this->postsRepository->findPosts($this->query));
    }

    #[LiveAction]
    public function paginateContacts(#[LiveArg()] int $page)
    {
        $this->offset = (($page - 1) * $this->limit);
        $this->page = $page;
    }
}
