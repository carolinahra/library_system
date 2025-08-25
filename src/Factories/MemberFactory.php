<?php

namespace Factories;
use Models\Member;

readonly final class MemberFactory extends Factory
{

    /**
     * @param int|null $id
     * @param mixed $name
     * @param mixed $email
     * @param mixed $state
     * @param mixed $limit
     * @param mixed $offset
     * @return Member[]|Member
     */
    public function get(?int $id = null, ?string $name = null, ?string $email = null, ?int $state = null, ?int $limit = null, ?int $offset = null): array|Member
    {
        if ($id) {
            return $this->getById(($id));
        }
        if ($name) {
            return $this->getByName($name, $limit, $offset);
        }
        if ($email) {
            return $this->getByEmail($email);
        }
        if ($state) {
            return $this->getByState($state);
        }
        return $this->getAll($limit, $offset);
    }
    public function insert(string $name, string $email, int $state): Member
    {
        $id = $this->databaseService->insert("INSERT IGNORE INTO Member (name, email, state)  VALUES (?,?,?)", [$name, $email, $state]);

        return $this->getById($id);
    }

    public function update(string $email, ?string $name = null, ?int $state = null): Member
    {
        if ($name) {
            return $this->updateName($name, $email);
        }
        return $this->updateState($state, $email);
    }

    public function delete(string $email): bool
    {
        return $this->databaseService->delete("DELETE FROM Member WHERE email = ?", [$email]);
    }

    private function getById(int $id): Member
    {
        $result = $this->databaseService->get("SELECT * FROM Member WHERE id = ?", [$id])[0];
        $member = new Member((int) $result['id'], $result['name'], $result['email'], $result['state'], $result['created_at'], $result['updated_at']);
        return $member;
    }

    private function getByName(string $name, int $limit, int $offset): array
    {
        $results = $this->databaseService->get("SELECT * FROM Member WHERE name = ? LIMIT ? OFFSET ?", [$name, $limit, $offset]);
        $members = array_map(callback: fn($result): Member => new Member((int) $result['id'], $result['name'], $result['email'], $result['state'], $result['created_at'], $result['updated_at']), array: $results);
        return $members;
    }

    private function getAll(int $limit, int $offset): array
    {
        $results = $this->databaseService->get("SELECT * FROM Member LIMIT ? OFFSET ?", [$limit, $offset]);
        $members = array_map(callback: fn($result): Member => new Member((int) $result['id'], $result['name'], $result['email'], $result['state'], $result['created_at'], $result['updated_at']), array: $results);
        return $members;
    }

    private function getByState(string $state): array
    {
        $results = $this->databaseService->get("SELECT * FROM Member WHERE state = ?", [$state]);
        $members = array_map(callback: fn($result): Member => new Member((int) $result['id'], $result['name'], $result['email'], $result['state'], $result['created_at'], $result['updated_at']), array: $results);
        return $members;
    }
    private function getByEmail(string $email): Member
    {
        $result = $this->databaseService->get("SELECT * FROM Member WHERE email = ?", [$email])[0];
        $member = new Member((int) $result["id"], $result["name"], $result["email"], $result["state"], $result["created_at"], $result["updated_at"]);
        return $member;
    }

    private function updateName(string $name, string $email): Member | null
    {
        $modifiedRows = $this->databaseService->update("UPDATE Member SET name = ? WHERE email = ? LIMIT ? OFFSET ?", [$name, $email]);
        if ($modifiedRows  == 0) {
            return null;
        }
        return $this->getByEmail($email);
    }
    private function updateState(string $state, string $email): Member | null
    {
        $modifiedRows = $this->databaseService->update("UPDATE Member SET state = ? WHERE email = ?", [$state, $email]);
        if ($modifiedRows == 0) {
            return null;
        }
        return $this->getByEmail($email);
    }
}
