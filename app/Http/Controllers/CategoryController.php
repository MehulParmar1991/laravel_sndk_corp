<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Sub_category;
use App\Models\Product;
use App\Models\Product_images;
use App\Models\Product_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class CategoryController
 *
 * @package App\Http\Controllers
 */
class CategoryController extends Controller {

    /**
     * Display the list of products with associated categories.
     *
     * Retrieves product categories and renders the product list view.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        //$data['categories'] = Category::get(["name", "id"]);
        return view('admin/categories.index');
    }

    /**
     * Fetch all categories and generate an HTML table for display.
     *
     * Retrieves all categories from the database and dynamically generates an HTML table
     * with category details, including an option to edit or delete each category.
     *
     * @return void
     */
    public function fetchallCategories() {
        $categories = Category::all();
        $output = '';
        if ($categories->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($categories as $category) {
                $output .= '<tr>
                <td>' . $category->id . '</td>
                <td>' . $category->name . '</td>                 
                <td>
                  <a href="#" id="' . $category->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $category->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }

    /**
     * Store a new category with associated details in the database.
     *
     * Handles the creation and storage of a new category, including its image, additional
     * images, and details such as sizes, item prices, and discounted prices.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {

        // Create an array with category data
        $categoryData = [
            'name' => $request->category_name
        ];
        // Create a new category record
        $category = Category::create($categoryData);

        // Respond with a JSON success message
        return response()->json([
                    'status' => 200,
        ]);
    }

    /**
     * Retrieve and return category details for editing.
     *
     * Retrieves the details of a specific category identified by its ID
     * and returns the data in JSON format for editing purposes.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request) {
        // Extract category ID from the request
        $id = $request->id;

        // Retrieve category details by ID
        $category = Category::find($id);

        return response()->json($category);
    }

    public function populateCategories(Request $request) {
        $category = Category::all();

        return response()->json($category);
    }

    /**
     * Update category details in the database.
     *
     * Handles the update of category details,Updates the category record in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request) {
        // Find the catgory record by ID
        $category = Category::find($request->emp_id);

        // Prepare data for updating the category record
        $categoryData = [
            'name' => $request->category_name
        ];

        // Update the catgory record in the database
        $category->update($categoryData);

        // Respond with a JSON success message
        return response()->json([
                    'status' => 200,
        ]);
    }

    /**
     * Delete a category details from the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function delete(Request $request) {
         try {
        // Extract category ID from the request
        $id = $request->id;

        // Find the category record by ID
        $category = Category::find($id);
        Category::destroy($id);
        return response()->json(['message' => 'Category deleted successfully']);
         } catch (\Exception $e) {
        // Handle the exception
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }
}
