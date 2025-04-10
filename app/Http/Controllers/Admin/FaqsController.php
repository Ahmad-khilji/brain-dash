<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faqs;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FaqsController extends Controller
{
    use ResponseTrait;
    public function index(Request $request)
{
    if ($request->ajax()) {
        // Query for fetching faqs data
        $data = Faqs::select('id', 'question', 'option_a', 'option_b', 'option_c', 'option_d')->get();

        // Return DataTables response
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                // Prepare the delete and edit actions
                $delete = "deleteModal('" . $row->id . "');";
                $edit = "editModal('" . $row->id . "','" . addslashes($row->question) . "','" . addslashes($row->option_a) . "','" . addslashes($row->option_b) . "','" . addslashes($row->option_c) . "','" . addslashes($row->option_d) . "');";

                // Return the action buttons (Edit and Delete)
                return '<button onclick="' . $edit . '" class="btn btn-primary">Edit</button>
                        <button class="btn btn-danger" onclick="' . $delete . '">Delete</button>';
            })
            ->rawColumns(['action']) // Make sure action buttons are rendered as raw HTML
            ->make(true);
    }

    // Return the view if it's not an AJAX request
    return view('admin.pages.faqs.index');
}

    // public function store(Request $request)
    // {
    //     // Trim whitespace from the input
    //     $request->merge(['letter' => str_replace(' ', '', $request->letter)]);

    //     // Validate the request
    //     $request->validate([
    //         'letter' => [
    //             'required',
    //             'string',
    //             'size:3',
    //             'regex:/^[a-zA-Z]+$/' // Only allow alphabetic characters
    //         ],
    //         'theme' => 'required|exists:themes,id',
    //         'date' => 'nullable|date',
    //     ]);

    //     // Fetch the theme details
    //     $theme = Theme::find($request->theme);

    //     // Check if theme has date restrictions
    //     $hasDateRestriction = $theme->start_date && $theme->end_date;

    //     // Check if a valid date is provided
    //     if ($request->date) {
    //         try {
    //             $validatedDate = \Carbon\Carbon::parse($request->date)->format('Y-m-d');

    //             // Get the conflicting letter if date exists
    //             $conflictingLetter = ThreeWordGame::whereDate('date', $validatedDate)
    //                 ->value('letter');

    //             if ($conflictingLetter) {
    //                 return response()->json([
    //                     'status' => 'error',
    //                     'type' => 'date',
    //                     'message' => 'The date already has word "(' . $conflictingLetter . ')" assigned!',
    //                     'conflicting_letter' => $conflictingLetter
    //                 ], 422);
    //             }
    //         } catch (\Exception $e) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'type' => 'date_format',
    //                 'message' => 'Invalid date format provided!'
    //             ], 422);
    //         }

    //         // For themes WITH date restrictions - additional validation
    //         if ($hasDateRestriction) {
    //             $providedDate = \Carbon\Carbon::parse($request->date);
    //             $startDate = \Carbon\Carbon::parse($theme->start_date);
    //             $endDate = \Carbon\Carbon::parse($theme->end_date);

    //             if (!$providedDate->between($startDate, $endDate)) {
    //                 return response()->json([
    //                     'status' => 'error',
    //                     'type' => 'date_range',
    //                     'message' => 'The date must be between ' . $theme->start_date . ' and ' . $theme->end_date . ' for this theme!'
    //                 ], 422);
    //             }
    //         }
    //     }

    //     // Check if letter already exists for this theme (case-insensitive)
    //     $letterExists = ThreeWordGame::whereRaw('LOWER(letter) = ?', [strtolower($request->letter)])
    //         ->where('theme', $request->theme)
    //         ->exists();

    //     if ($letterExists) {
    //         return response()->json([
    //             'status' => 'error',
    //             'type' => 'letter',
    //             'message' => 'Word "' . $request->letter . '" already exists for the selected theme!'
    //         ], 422);
    //     }

    //     DB::beginTransaction();

    //     try {
    //         ThreeWordGame::create([
    //             'letter' => strtoupper($request->letter), // Store in uppercase
    //             'date' => $request->date ?? null,
    //             'theme' => $request->theme,
    //             'status' => $request->date ? 1 : 0,
    //         ]);

    //         DB::commit();
    //         return $this->SuccessResponse(message: 'Three Word detail saved successfully');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         info('ThreeWordController@store');
    //         info('Error: ' . $e->getMessage());
    //         info('On Line: ' . $e->getLine());

    //         return $this->ErrorResponse('Failed to save Three Word detail: ' . $e->getMessage());
    //     }
    // }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
        ]);
    
        try {
            // Find the FAQ record by ID
            $faq = Faqs::findOrFail($id);
    
            // Update the record with the new values from the request
            $faq->update([
                'question' => $request->question,
                'option_a' => $request->option_a,
                'option_b' => $request->option_b,
                'option_c' => $request->option_c,
                'option_d' => $request->option_d,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'FAQ updated successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update FAQ: ' . $e->getMessage(),
            ]);
        }
    }
    
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        DB::beginTransaction();
        try {
            // Find the category
            $category = Faqs::findOrFail($request->id);
            // Delete the category
            $category->delete();

            DB::commit();
            return $this->SuccessResponse(message: 'Faqs deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            info('FaqsController@delete');
            info('Error: ' . $e->getMessage());
            info('On Line: ' . $e->getLine());
            return $this->ErrorResponse('Failed to delete Faqs: ' . $e->getMessage());
        }
    }

    public function importFaqs(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);
    
        $file = $request->file('file');
        $handle = fopen($file, "r");
        $headers = fgetcsv($handle); // Read header row
    
        $imported = 0;
        $errors = [];
    
        while (($row = fgetcsv($handle)) !== false) {
            if (count(array_filter($row)) == 0) continue;
    
            if (count($row) < 5) {
                $errors[] = "Row skipped due to missing values: " . implode(", ", $row);
                continue;
            }
    
            // Check if the question already exists
            $existingFaq = Faqs::where('question', trim($row[0]))->first();
    
            if ($existingFaq) {
                $errors[] = "Duplicate question found: '" . htmlspecialchars(trim($row[0])) . "";
                continue;
            }
    
            try {
                Faqs::create([
                    'question' => trim($row[0]),
                    'option_a' => trim($row[1]),
                    'option_b' => trim($row[2]),
                    'option_c' => trim($row[3]),
                    'option_d' => trim($row[4]),
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Error on row: " . implode(", ", $row) . " | " . $e->getMessage();
            }
        }
    
        fclose($handle);
    
        // Decode HTML entities before showing the error
        if (!empty($errors)) {
            $errorMessages = array_map(function($error) {
                return html_entity_decode($error);  // Decode the HTML entities
            }, $errors);
    
            return redirect()->back()->with('error', implode("<br>", $errorMessages));
        }
    
        return redirect()->back()->with('success', "$imported questions imported successfully!");
    }
    

}
