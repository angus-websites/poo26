<?php

namespace App\Repositories;

use App\Contracts\SlugRepositoryInterface;
use App\Models\Slug;
use Illuminate\Support\Collection;

class SlugRepository implements SlugRepositoryInterface
{

    public function create(array $data): Slug
    {
        return Slug::create($data);
    }

    public function findById(int $id): ?Slug
    {
        return Slug::find($id);
    }

    public function findByCode(string $code): ?Slug
    {
        return Slug::where('code', $code)
            ->first();
    }

    public function all(): Collection
    {
        return Slug::all();
    }

    public function update(Slug $link, array $data): Slug
    {
        $link->update($data);

        return $link;
    }

    public function delete(Slug $link): bool
    {
        return (bool) $link->delete();
    }
}
