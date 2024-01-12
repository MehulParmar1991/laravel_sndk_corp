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
 * Class ProductController
 *
 * @package App\Http\Controllers
 */
class ProductController extends Controller {

    /**
     * Display the list of products with associated categories.
     *
     * Retrieves product categories and renders the product list view.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        $data['categories'] = Category::get(["name", "id"]);
        return view('admin/products.index', $data);
    }

    /**
     * Fetch all products and generate an HTML table for display.
     *
     * Retrieves all products from the database and dynamically generates an HTML table
     * with product details, including an option to edit or delete each product.
     *
     * @return void
     */
    public function fetchAll() {
        //$products = Product::all();
        $products = Product::with('category', 'subcategory')->get();
        $output = '';
        if ($products->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Featured Image</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Sub Category</th>                
                <th>Brand Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($products as $product) {
                $output .= '<tr>
                <td>' . $product->id . '</td>
                <td><img src="storage/images/' . $product->avatar . '" width="50" class="img-thumbnail rounded-circle"></td>
                <td>' . $product->product_name . '</td>                
                <td>' . $product->category->name . '</td>
                <td>' . $product->subcategory->name . '</td>    
                <td>' . $product->brand_name . '</td>    
                <td>
                  <a href="#" id="' . $product->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $product->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
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
     * Store a new product with associated details in the database.
     *
     * Handles the creation and storage of a new product, including its image, additional
     * images, and details such as sizes, item prices, and discounted prices.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {

        // Upload and store the featured image
        $file = $request->file('avatar');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $fileName);

        // Create an array with product data
        $productData = [
            'product_name' => $request->product_name,
            'brand_name' => $request->brand_name,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'avatar' => $fileName
        ];
        // Create a new product record
        $product = Product::create($productData);

        // Retrieve the product ID
        $product_id = $product->id;

        // Handle additional product images
        if ($request->hasFile('files')) {
            $files = $request->file('files');

            foreach ($files as $file) {

                // You can store the file, validate, or perform any needed operations here
                $fileName = $file->getClientOriginalName();
                $filepath = 'public/images/' . $product_id;
                if (!file_exists($filepath)) {
                    mkdir($filepath, 0777, true); // Create the directory recursively
                }
                $file->storeAs($filepath, $fileName); // Store in publoc/images/product_id folder                
                // Create a record for each additional product image
                $productImagData = ['product_id' => $product_id, 'image' => $fileName];                
                Product_images::create($productImagData);
            }
        }

        // Handle product details (sizes, item prices, discounted prices)
        if (count($request->sizes) > 0) {
            foreach ($request->sizes as $k => $size) {
                // Create a record for each product detail
                $productDetails = ['product_id' => $product_id, 'size' => $size, 'item_price' => $request->item_prices[$k], 'discounted_price' => $request->discounted_prices[$k]];
                Product_details::create($productDetails);
            }
        }

        // Respond with a JSON success message
        return response()->json([
                    'status' => 200,
        ]);
    }

    /**
     * Retrieve and return product details for editing.
     *
     * Retrieves the details of a specific product identified by its ID
     * and returns the data in JSON format for editing purposes.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request) {
        // Extract product ID from the request
        $id = $request->id;

        // Retrieve product details by ID
        //$product = Product::find($id);
        $product = Product::with('category', 'subcategory')->find($id);

        // Retrieve product images details by ID
        $productImages = Product_images::where('product_id', $id)->get()->toArray();
        $product->product_images = array_column($productImages, 'image');
        // Return product details in JSON format
        return response()->json($product);
    }

    /**
     * Update product details in the database.
     *
     * Handles the update of product details, including the option to update the featured image.
     * If a new image is provided, it is uploaded, and the previous image is deleted. If no new image
     * is provided, the existing image is retained. Updates the product record in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request) {
        // Initialize variable for the file name
        $fileName = '';
        // Find the product record by ID
        $product = Product::find($request->emp_id);
        if ($request->hasFile('avatar')) {
            // Upload and store the new featured image
            $file = $request->file('avatar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName);
            // Delete the previous image if it exists
            if ($product->avatar) {
                Storage::delete('public/images/' . $product->avatar);
            }
        } else {
            // Use the existing image if no new image is provided
            $fileName = $request->emp_avatar;
        }

        // Prepare data for updating the product record
        $productData = [
            'product_name' => $request->product_name,
            'brand_name' => $request->brand_name,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'avatar' => $fileName
        ];

        // Update the product record in the database
        $product->update($productData);

        // Respond with a JSON success message
        return response()->json([
                    'status' => 200,
        ]);
    }

    /**
     * Delete a product and associated details from the database.
     *
     * Handles the deletion of a specific product and its related details, including
     * product details (sizes, prices) and additional images. Also, deletes the
     * featured image and removes the product record from the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function delete(Request $request) {
        // Extract product ID from the request
        $id = $request->id;

        // Find the product record by ID
        $product = Product::find($id);

        // Delete product details (sizes, prices)
        Product_details::where('product_id', $id)->delete();

        // Delete additional product images
        Product_images::where('product_id', $id)->delete();

        // Delete the featured image and the product record if successful
        if (Storage::delete('public/images/' . $product->avatar)) {
            Product::destroy($id);
        }
    }
}
