<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // دالة مساعدة للتحقق من التوكن
    private function verifyToken($request)
    {
        $token = $request->bearerToken();
        if (!$token) return null;
        
        return User::where('api_token', hash('sha256', $token))->first();
    }
    
    public function index(Request $request)
    {
        $user = $this->verifyToken($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        return Product::all();
    }
    
    public function store(Request $request)
    {
        $user = $this->verifyToken($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric'
        ]);
        
        $product = Product::create($request->all());
        
        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }
    
    public function show(Request $request, $id)
    {
        $user = $this->verifyToken($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        return Product::findOrFail($id);
    }
    
    public function update(Request $request, $id)
    {
        $user = $this->verifyToken($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        $product = Product::findOrFail($id);
        $product->update($request->all());
        
        return response()->json(['message' => 'Product updated']);
    }
    
    public function destroy(Request $request, $id)
    {
        $user = $this->verifyToken($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}