<?php

namespace App\Http\Controllers;

use App\Http\Requests\Instruction\InstructionCreateRequest;
use App\Http\Requests\Instruction\InstructionUpdateRequest;
use App\Http\Resources\InstructionResponse;
use App\Services\InstructionService;
use Illuminate\Http\Request;
use Symfony\Component\Console\Output\ConsoleOutput;

class InstructionController extends Controller
{
    public function __construct(
        private readonly InstructionService $instructionService,
    ) {
    }
    public function create(int $recipeId, InstructionCreateRequest $request)
    {
        $response = $this->instructionService->create($recipeId, $request);

        return $response;
    }
    public function update(int $recipeId, InstructionUpdateRequest $request)
    {
        $response = $this->instructionService->update($recipeId, $request);

        return $response;
    }
    public function delete(int $recipeId, int $instructionId)
    {
        $this->instructionService->delete($recipeId, $instructionId);
        return response(["message" => "success"], 200);
    }
}
