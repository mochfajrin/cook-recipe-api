<?php

namespace App\Http\Controllers;

use App\Http\Requests\Instruction\InstructionCreateRequest;
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
}
