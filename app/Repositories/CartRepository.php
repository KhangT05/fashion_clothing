<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\Clock\now;

class CartRepository extends BaseRepository
{
    public function __construct(
        Cart $model
    ) {
        $this->model = $model;
    }
    public function cartIndex($user_id)
    {
        // giá bán trong sản phẩm là giá chuẩn
        // giá bán trong variant là giá theo thị trường
        $items = DB::table('cart')
            ->join('product_variant', 'cart.sku', '=', 'product_variant.sku')
            ->join('product', 'product_variant.product_id', '=', 'product.id')
            ->leftJoin('variant_attribute_values', 'product_variant.id', '=', 'variant_attribute_values.product_variant_id')
            ->leftJoin('attribute_category', 'variant_attribute_values.attribute_category_id', '=', 'attribute_category.id')
            ->leftJoin('attribute', 'attribute_category.attribute_id', '=', 'attribute.id')
            ->where('user_id', $user_id)
            ->select(
                'cart.id as cart_id',
                'cart.sku',
                'cart.quantity as cart_quantity',
                'product.id as product_id',
                'product.name',
                'product.discount',
                'product.image',
                'product.slug',
                'product_variant.price',
                'product_variant.quantity as stock_quantity',
                'attribute_category.value as value',
                'attribute.type as type',
                'attribute_category.code as code'
            )
            ->orderBy('cart.id')
            ->orderBy('attribute.id')
            ->get();
        return $this->groupedCart($items);
    }
    private function groupedCart($items)
    {
        $grouped = [];
        foreach ($items as $item) {
            $sku = $item->sku;
            // lấy sản phẩm với mã sku
            if (!isset($grouped[$sku])) {
                $grouped[$sku] = [
                    'cart_id' => $item->cart_id,
                    'sku' => $item->sku,
                    'product_id' => $item->product_id,
                    'name' => $item->name,
                    'image' => $item->image,
                    'slug' => $item->slug,
                    'price' => $item->price,
                    'discount' => $item->discount,
                    'cart_quantity' => $item->cart_quantity,
                    'stock_quantity' => $item->stock_quantity,
                    'subtotal' => ($item->price * $item->cart_quantity)
                        * (1 - $item->discount / 100),
                    'attributes' => [],
                ];
            }
            if ($item->value) {
                $grouped[$sku]['attributes'][] = [
                    'type' => $item->type ?? 'Thuộc tính',
                    'value' => $item->value,
                    'code' => $item->code ?? null
                ];
            }
        }
        return $grouped;
    }
    public function getSummary()
    {
        $user_id = Auth::id();
        if (!$user_id) {
            return response()->json([
                'totalQuantity' => 0,
                'totalAmount' => 0
            ]);
        }
        $cartSummary = DB::table('cart')
            ->join('product_variant', 'cart.sku', '=', 'product_variant.sku')
            ->where('user_id', $user_id)
            ->select(
                DB::raw('SUM(cart.quantity) as total_quantity'),
                DB::raw('SUM(product_variant.price * cart.quantity) as total_amount')
            )
            ->first();
        return response()->json([
            'totalQuantity' => $cartSummary->total_quantity ?? 0,
            'totalAmount' => $cartSummary->total_amount ?? 0
        ]);
    }
    public function findByProductAndUser($product_id, $userId)
    {
        return Cart::where('product_id', $product_id)
            ->where('user_id', $userId)
            ->with('product')
            ->first();
    }
    public function updateQuantity($id, $quantity)
    {
        $result = $this->findById($id);
        $result->update([
            'quantity' => $quantity,
            'update_at' => now()
        ]);
        return $result;
    }
    public function calculateTotals($cartItems, $selectedIds = null)
    {
        $totalQuantity = 0;
        $totalAmount = 0;

        foreach ($cartItems as $item) {
            if ($selectedIds !== null && !in_array($item['cart_id'], $selectedIds)) {
                continue;
            }
            $totalQuantity += $item['cart_quantity'];
            $totalAmount += $item['subtotal'];
        }
        return [
            'totalQuantity' => $totalQuantity,
            'totalAmount' => $totalAmount
        ];
    }
    public function getCheckoutData($cart_ids, $user_id)
    {
        $allCarts = $this->cartIndex($user_id);
        $selectedCarts = array_filter($allCarts, function ($cart) use ($cart_ids) {
            return in_array($cart['cart_id'], $cart_ids);
        });
        if (empty($selectedCarts)) {
            return null;
        }
        $totals = $this->calculateTotals($selectedCarts);
        $totalDiscount = array_reduce($selectedCarts, function ($sum, $cart) {
            return $sum + ($cart['price'] * $cart['cart_quantity'] * $cart['discount'] / 100);
        }, 0);
        $checkout = [
            'items' => array_map(function ($cart) {
                return [
                    'cart_id' => $cart['cart_id'],
                    'product_id' => $cart['product_id'],
                    'name' => $cart['name'],
                    'so_luong' => $cart['cart_quantity'],
                    'gia_goc' => $cart['price'],
                    'thanh_tien' => $cart['subtotal'],
                    'image' => $cart['image'],
                    'discount' => $cart['discount'],
                    'sku' => $cart['sku'],
                    'attributes' => $cart['attributes'],
                ];
            }, $selectedCarts),
            'totalPrice' => $totals['totalAmount'] - $totalDiscount, // Tổng sau giảm
            'totalQuantity' => $totals['totalQuantity'],
            'totalDiscount' => $totalDiscount,
            'totalAmount' => $totals['totalAmount'], // Tổng gốc
            'finalPrice' => $totals['totalAmount'] - $totalDiscount,
        ];

        return $checkout;
    }
}
