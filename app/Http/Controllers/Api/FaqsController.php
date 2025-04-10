<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faqs;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    use ResponseTrait;
    public function fetchAllFaqs()
    {
        $faqs = Faqs::select('id', 'question', 'option_a', 'option_b', 'option_c', 'option_d')
            ->get();

        if ($faqs->isEmpty()) {
            return $this->ErrorResponse('No FAQs found');
        }

        return $this->SuccessResponse(message: 'FAQs fetched successfully', data: $faqs);
    }
}
