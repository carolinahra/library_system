<?php

namespace Controllers;

use Models\Member;
use Services\MemberService;
use Requests\MemberRequests\GetMemberRequestDTO;
use Requests\MemberRequests\InsertMemberRequestDTO;
use Requests\MemberRequests\DeleteMemberRequestDTO;
use Requests\MemberRequests\UpdateMemberRequestDTO;


readonly final class MemberController
{
    public function __construct(private MemberService $memberService) {}

    public function get(GetMemberRequestDTO $request): array|Member
    {
        return $this->memberService->get($request->id, $request->name, $request->email, $request->state, $request->limit, $request->offset);
    }

    public function insert(InsertMemberRequestDTO $request): Member
    {
        return $this->memberService->insert($request->name, $request->email, $request->state);
    }

    public function update(UpdateMemberRequestDTO $request): Member
    {
        return $this->memberService->update($request->name, $request->email, $request->state);
    }

    public function delete(DeleteMemberRequestDTO $request): bool
    {
        return $this->memberService->delete($request->email);
    }
}
