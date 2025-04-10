<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Analytic;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AnalyticController extends Controller
{
    use ResponseTrait;
    public function index(Request $request)
    {

        $request->validate([
            'streak' => 'required|integer',
            'max_question' => 'required|integer',
            'right_question' => 'required|integer',
            'wrong_question' => 'required|integer',
        ]);

        try {
            $analytics = Analytic::create([
                'streak' => $request->streak,
                'max_question' => $request->max_question,
                'right_question' => $request->right_question,
                'wrong_question' => $request->wrong_question,
            ]);
            return $this->SuccessResponse(message: 'Analytics data stored successfully!', data: $analytics);
        } catch (\Exception $e) {
            return $this->ErrorResponse('Failed to store analytics data: ' . $e->getMessage());
        }
    }
}
